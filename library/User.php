<?php

include "autoload.php";

class User extends Person
{
    private $about;
    private $image;
    
    function __construct()
    {
        $this->about = "";
        $this->image = null;
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