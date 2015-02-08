<?php

include "autoload.php";

class User extends Person
{
    private $about;
    private $image;
    
    function __construct()
    {
        parent();
        $this->about = "";
        $this->image = null;
    }
    
    /**
     * This function will set the user properties
     * from the user table.
     */
    public function set_details_from_database()
    {
        
    }
    
    /**
     * This function updates the password of the user with
     * the new password.
     * @param string $new_password
     */
    public function change_password($new_password)
    {
        
    }
    
    /**
     * This function updates the data in User table
     * with the current value of the properties.
     */
    public function save_changes()
    {
        
    }
}

?>