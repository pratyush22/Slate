<?php

include "autoload.php";

class User extends Person
{
    private $about;
    private $image;
    private $is_all_set;
    
    function __construct()
    {
        $this->about = "";
        $this->image = null;
        $this->is_all_set = false;
    }
    
    /**
     * This function returns "about" data
     * for the user.
     * @return string
     */
    public function get_about()
    {
        return $this->about;
    }
    
    /**
     * This function returns the path to the image.
     * @return string
     */
    public function get_image()
    {
        return $this->image;
    }
    
    /**
     * This function will set the user properties
     * from the user table.
     */
    public function set_details_from_database($username)
    {
        $query = "SELECT * FROM user WHERE username = :username";
        $fetched_successfully = true;
        
        try
        {
            $db = new DatabaseConnection();
            $connection = $db->get_connection();
            $statement = $connection->prepare($query);
            $statement->bindParam(":username", $username);
            $statement->execute();
            
            //  Set the resulting array to associative
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $result = $statement->fetch();
            
            if ($result)
            {
                $this->username = $result["username"];
                $this->email = $result["email"];
                $this->name = $result["name"];
                $this->about = $result["about"];
                $this->image = $result["image"];
                $this->password = $result["password"];
                
                $this->is_all_set = true;
            }
            else
            {
                $fetched_successfully = false;
            }
            
            $statement = null;
            $connection = null;
        }
        catch (PDOException $ex)
        {
            $fetched_successfully = false;
            $this->error = "Database Issue: ".$ex->getMessage();
        }
        
        return $fetched_successfully;
    }
    
    /**
     * This function updates the password of the user with
     * the new password.
     * @param string $new_password
     */
    public function change_password($old_password, $new_password, $confirm_password)
    {
        $password_changed = false;
        $query = "UPDATE user SET password = :password WHERE username = :username";
        
        if (!$this->verify_password($old_password, $new_password, $confirm_password))
        {
            return false;
        }
        
        try
        {
            $db = new DatabaseConnection();
            $connection = $db->get_connection();
            $statement = $connection->prepare($query);
            $statement->bindParam(":password", $new_password);
            $statement->bindParam(":username", $this->username);
            $statement->execute();
            
            $password_changed = true;
            $statement = null;
            $connection = null;
        }
        catch (PDOException $ex)
        {
            $this->error = $ex->getMessage();
        }
        
        return $password_changed;
    }
    
    /**
     * This function is used to verify the user input before updating the
     * passwords.
     * @param string $old_password
     * @param string $new_password
     * @param string $confirm_password
     * @return boolean
     */
    private function verify_password($old_password, $new_password, $confirm_password)
    {
        $is_passwords_valid = true;
        
        if (!$this->is_all_set)
        {
            $this->error = "Set the details before changing password";
            $is_passwords_valid = false;
        }
        else if (strcmp($old_password, $this->password))
        {
            $this->error = "Old password did not match with current password";
            $is_passwords_valid = false;
        }
        else if (empty($new_password) || empty($confirm_password))
        {
            $this->error = "Some fields are missing";
            $is_passwords_valid = false;
        }
        else if (strcmp($new_password, $confirm_password))
        {
            $this->error = "New password and Confirm password did not match";
            $is_passwords_valid = false;
        }
        
        return $is_passwords_valid;
    }
    
    /**
     * This function updates the data in User table
     * with the current value of the properties.
     */
    public function save_changes()
    {
        
    }
    
    /**
     * Function to delete user account.
     * All details must be set before calling this function.
     */
    public function delete_account()
    {
        $query = "DELETE FROM user WHERE username = :username";
        
        if (!$this->is_all_set)
        {
            $this->error = "Set all the user's details before deleting";
            return false;
        }
        
        try
        {
            $db = new DatabaseConnection();
            $connection = $db->get_connection();
            $statement = $connection->prepare($query);
            $statement->bindParam(":username", $this->username);
            $statement->execute();
            
            $statement = null;
            $connection = null;
        }
        catch (PDOException $ex)
        {
            $this->error = $ex->getMessage();
            return false;
        }
        
        return true;
    }
}

?>