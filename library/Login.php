<?php
    include "autoload.php";
    
    /**
     * This class will handle the login process
     * for the application.
     */
    class Login
    {
        private $email;
        private $password;
        private $error;
        private $username;
        private $name;
        
        function __construct()
        {
            $this->email = "";
            $this->password = "";
            $this->error = "";
            $this->username = "";
            $this->name = "";
        }
        
        /**
         * This function sets the email property.
         * @param string $email
         */
        public function set_email($email)
        {
            $this->email = $email;
        }
        
        /**
         * This function sets the password property.
         * @param string $password
         */
        public function set_password($password)
        {
            $this->password = $password;
        }
        
        /**
         * This function returns the error, if any otherwise
         * an empty string will be returned.
         * @return string
         */
        public function get_error()
        {
            return $this->error;
        }
        
        /**
         * This function returns the username if login operation
         * is successful otherwise an empty string will be returned.
         * @return string
         */
        public function get_username()
        {
            return $this->username;
        }
        
        /**
         * This function returns the name of the user if login
         * operation is successful otherwise an empty string will
         * be returned.
         * @return string
         */
        public function get_name()
        {
            return $this->name;
        }
        
        /**
         * This function whether login attempt is successful or not.
         * @return boolean
         */
        public function login()
        {
            $login = true;
            
            try
            {
                $db_object = new DatabaseConnection();
                $connection = $db_object->get_connection();
                $query = "SELECT username, name FROM user WHERE email=:email AND password=:password";
                $statement = $connection->prepare($query);
                $statement->bindParam(":email", $this->email);
                $statement->bindParam(":password", $this->password);

                if ($statement->execute())
                {
                    if ($row = $statement->fetch(PDO::FETCH_ASSOC))
                    {
                        $this->username = $row['username'];
                        $this->name = $row['name'];
                    }
                    else
                    {
                        $login = false;
                        $this->error = "email or password did not match";
                    }
                }
                else
                    $login = false;
                
                $statement = null;
                $connection = null;
            }
            catch (PDOException $ex)
            {
                $login = false;
                $this->error = "incorrect email or password";
                Logger::write_log("Login", $ex->getMessage());
            }
            
            return $login;
        }
    }
?>