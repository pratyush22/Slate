<?php
    include "autoload.php";
    
    abstract class Person
    {
        protected $id;
        protected $name;
        protected $username;
        protected $email;
        protected $password;
        protected $error;
        protected $gender;
        
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
         * This function sets the gender of the user.
         * @param string $gender
         */
        public function set_gender($gender)
        {
            $this->gender = $gender;
        }
        
        /**
         * This function returns the unique id of the user.
         * All details must be set before calling this function.
         * @return int
         */
        public function get_id()
        {
            return $this->id;
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
         * This function returns the gender of the user.
         * @return string
         */
        public function get_gender()
        {
           return $this->gender; 
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
        abstract protected function change_password($old_password, $new_password, $confirm_password);
        
        /**
         * This function is used for saving the changes to
         * the database.
         */
        abstract protected function save_changes();
        
        /**
         * This function is used to delete user account.
         * All details must be set before calling this function.
         */
        abstract protected function delete_account();
    }
?>
