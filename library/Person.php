<?php
    include "autoload.php";
    
    abstract class Person
    {
        protected $name;
        protected $username;
        protected $email;
        protected $password;
        protected $error;
        
        function __construct()
        {
            $this->name = "";
            $this->email = "";
            $this->username = "";
            $this->password = "";
            $this->error = "";
        }
        
        /**
         * This function is used to set the name of the person.
         * @param string $name
         */
        public function set_name($name)
        {
            $this->name = $name;
        }
        
        /**
         * This function is used to set the username of the person.
         * @param string $username
         */
        public function set_username($username)
        {
            $this->username = $username;
        }
        
        /**
         * This function is used to get the name of the person.
         * @return string
         */
        public function get_name()
        {
            return $this->name;
        }
        
        /**
         * This function is used to get the username of the person.
         * @return string
         */
        public function get_username()
        {
            return $this->username;
        }
        
        /**
         * This function is used to get the email of the person.
         * @return string
         */
        public function get_email()
        {
            return $this->email;
        }
        
        /**
         * This function returns the error if any otherwise
         * an empty string is returned.
         * @return string
         */
        public function get_error()
        {
            return $this->error;
        }
        
        /**
         * This function is used to set the person details
         * from the database.
         */
        abstract protected function set_details_from_database($username);
        
        /*
         * This function is used for changing the person's
         * password.
         */
        abstract protected function change_password($new_password);
        
        /**
         * This function is used for saving the changes to
         * the database.
         */
        abstract protected function save_changes();
    }
?>
