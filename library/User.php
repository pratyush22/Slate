<?php

include "autoload.php";

class User extends Person
{
    private $about;
    private $image;
    private $is_all_set;
    
    function __construct()
    {
        $this->id = "";
        $this->name = " ";
        $this->email = "";
        $this->username = "";
        $this->gender = " ";
        $this->password = "";
        $this->about = " ";
        $this->image = null;
        $this->is_all_set = false;
    }
    
    /**
     * This function sets the about property of the user.
     * @param string $about
     */
    public function set_about($about)
    {
        $this->about = $about;
    }
    
    /**
     * This function sets the image path property of the user.
     * @param string $image
     */
    public function set_image($image)
    {
        $this->image = $image;
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
                $this->gender = $result["gender"];
                $this->id = $result["id"];
                
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
            $this->error = "Can't set details now, try again later";
            Logger::write_log("User", $ex->getMessage());
        }
        
        return $fetched_successfully;
    }
    
    /**
     * This function updates the password of the user with
     * the new password.
     * @param string $new_password
     * @return boolean Is password changing successful
     */
    public function change_password($old_password, $new_password, $confirm_password)
    {
        $password_changed = false;
        $query = "UPDATE user SET password = :password WHERE username = :username";
        
        //  Verify the password before updating
        if (!$this->verify_password($old_password, $new_password, $confirm_password))
        {
            return false;
        }
        
        //  Now update the password
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
            $this->error = "Can't change password, try again later";
            Logger::write_log("User", $ex->getMessage());
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
     * @return boolean Are all changes successfully updated
     */
    public function save_changes()
    {
        $saved = false;
        $query = "UPDATE user SET name = :name, username = :username, gender = :gender, "
                . "about = :about, image = :image WHERE username = :old_username";
        
        $old_username = $this->username;
        $this->clean_data();
        $this->generate_username();
        
        try
        {
            $db = new DatabaseConnection();
            $connection = $db->get_connection();
            $statement = $connection->prepare($query);
            
            $statement->bindParam(":name", $this->name);
            $statement->bindParam(":username", $this->username);
            $statement->bindParam(":gender", $this->gender);
            $statement->bindParam(":about", $this->about);
            $statement->bindParam(":image", $this->image);
            $statement->bindParam(":old_username", $old_username);
            $statement->execute();
            
            $statement = null;
            $connection = null;
            
            $saved = true;
        }
        catch (PDOException $ex)
        {
            $this->error = "Cannot save changes, try again later";
            Login::write_log("User", $ex->getMessage());
        }
        
        return $saved;
    }
    
    /**
     * This function cleans the data or remove unnecessary spaces
     * from the data.
     */
    private function clean_data()
    {
        $this->name = trim($this->name);
        $this->name = stripslashes($this->name);
        
        $this->about = trim($this->about);
        $this->about = stripslashes($this->about);
    }
    
    /**
     * This function generates username from id and name.
     */
    private function generate_username()
    {
        $this->username = $this->name.".".$this->id;
        $this->username = str_replace(' ', '.', $this->username);
    }
    
    private function delete_directory($path)
    {
        if (substr($path, strlen($path) - 1, 1) != '/')
        {
            $path .= '/';
        }

        $files = glob($path . '*', GLOB_MARK);
        foreach ($files as $file) 
        {
            if (is_dir($file))
            {
                $this->delete_directory($file);
            }
            else
            {
                unlink($file);
            }
        }

        rmdir($path);
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
            //  If directory exists then delete it
            if (file_exists("./data/".$this->id))
            {
                $this->delete_directory("./data/".$this->id);
            }
                
                
            //  Delete the user image from the user's folder
            if (strcmp($this->image, "./images/Icon-user.png"))
            {
                if (!unlink($this->image))
                {
                    $this->error = "Your account can't be deleted";
                    return false;
                }
            }
            
            //  Delete the account from the database
            $db = new DatabaseConnection();
            $connection = $db->get_connection();
            $statement = $connection->prepare($query);
            $statement->bindParam(":username", $this->username);
            $statement->execute();
            
            //  Delete the posts with current user id from the database.
            $query = "DELETE FROM post WHERE uid = :uid";
            $statement = $connection->prepare($query);
            $statement->bindParam(":uid", $this->id);
            $statement->execute();
            
            $statement = null;
            $connection = null;
        }
        catch (PDOException $ex)
        {
            $this->error = "Can't delete account, try again later";
            Login::write_log("User", $ex->getMessage());
            return false;
        }
        
        return true;
    }
    
    public function set_min_details($uid)
    {
        try
        {
            $db = new DatabaseConnection();
            $connection = $db->get_connection();
            $query = "SELECT name, image, about FROM user WHERE id = :uid";
            $statement = $connection->prepare($query);
            $statement->bindParam(":uid", $uid);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $result = $statement->fetch();
            
            if ($result)
            {
                $this->name = $result["name"];
                $this->image = $result["image"];
                $this->about = $result["about"];
            }
            
            $statement = null;
            $connection = null;
        }
        catch (Exception $ex)
        {
            Logger::write_log("User", $ex->getMessage());
        }
    }
}

?>