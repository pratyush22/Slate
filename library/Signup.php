<?php

    include "autoload.php";
    
    /**
     * This class will handle the signup process
     * of the application. It will check and verify
     * the full name, email and password of the user. 
     */
    class Signup
    {   
        private $name;
        private $username;
        private $email;
        private $password;
        private $confirm_password;
        private $error;
        private $initial_image;
        
        function __construct()
        {
            $this->name = "";
            $this->email = "";
            $this->password = "";
            $this->confirm_password = "";
            $this->error = "";
            $this->initial_image = "./images/Icon-user.png";
        }
        
        /**
         * This function sets the name of the user.
         * @param string $name  Full name of the user
         */
        public function set_name($name)
        {
            $this->name = $name;
        }
        
        /**
         * This function sets the email of the user.
         * @param string $email
         */
        public function set_email($email)
        {
            $this->email = $email;
        }
        
        /**
         * This function sets the password of the user.
         * @param string $password
         */
        public function set_password($password)
        {
            $this->password = $password;
        }
        
        /**
         * This function sets the confirmation password
         * of the user.
         * @param string $confirm_password
         */
        public function set_confirm_password($confirm_password)
        {
            $this->confirm_password = $confirm_password;
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
         * This function returns the username of the user.
         * @return string username
         */
        public function get_username()
        {
            return $this->username;
        }
        
        /**
         * This function returns the name of the user.
         * @return string
         */
        public function get_name()
        {
            return $this->name;
        }
        
        /**
         * This function trims extra spaces around the
         * input and removes slashes from it, if any.
         */
        private function clean_input()
        {
            $this->name = trim($this->name);
            $this->name = stripslashes($this->name);
            $this->email = trim($this->email);
        }
        
        /**
         * This function verfies the input before inserting
         * it in the database.
         * @return boolean
         */
        private function verify_input()
        {
            $permitted = true;
            
            if (empty($this->name) || empty($this->email) ||
                    empty($this->password) || empty($this->confirm_password))
            {
                $permitted = false;
                $this->error = "Empty value";
            }
            else if (strlen($this->password) < 6 || strlen($this->confirm_password) < 6)
            {
                $permitted = false;
                $this->error = "Passwords should be of atleast 6 characters";
            }
            else if ( strlen($this->name) > 50 || strlen($this->email) > 100 ||
                    strlen($this->password) > 40)
            {
                $permitted = false;
                $this->error = "Length of the input is greater than acceptable.";
            }
            else if (strcmp($this->password, $this->confirm_password))
            {
                $permitted = false;
                $this->error = "Password and Confirm password did not match";
            }
            
            return $permitted;
        }
        
        /**
         * Generate username from the unique id of the user.
         * @param int $last_id
         */
        private function generate_username($last_id)
        {
            $this->username = $this->name.".".$last_id;
            $this->username = str_replace(' ', '.', $this->username);
        }
        
        /**
         * This function creates a new user and store its basic
         * information in the database.
         * @return boolean
         */
        public function signup()
        {
            $is_signed_up = true;
            
            //  Verify Inputs
            if (!$this->verify_input())
            {
                return false;
            }
            
            try
            {
                $db_object = new DatabaseConnection();
                $connection = $db_object->get_connection();

                //  Insert basic details
                $query = "INSERT INTO user(name, email, password, image) VALUES(:name, :email, :password, :image)";
                $statement = $connection->prepare($query);
                $statement->bindParam(":name", $this->name);
                $statement->bindParam(":email", $this->email);
                $statement->bindParam(":password", $this->password);
                $statement->bindParam(":image", $this->initial_image);
                $statement->execute();
                
                //  Generate and Insert username
                $last_id = $connection->lastInsertId();
                $this->generate_username($last_id);
                $query = "UPDATE user SET username=:username WHERE id=:id";
                $statement = $connection->prepare($query);
                $statement->bindParam(":username", $this->username);
                $statement->bindParam(":id", $last_id);
                $statement->execute();
                
                $statement = null;
                $connection = null;
                
            }
            catch (PDOException $ex)
            {
                $is_signed_up = false;
                $this->error = "Input not valid";
                Logger::write_log("Signup", $ex->getMessage());
            }
            
            return $is_signed_up;
        }
    }
?>