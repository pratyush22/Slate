<?php

include "./library/autoload.php";
include "./library/security.php";

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    try
    {
        $db = new DatabaseConnection();
        $connection = $db->get_connection();
        $query = "SELECT post FROM post WHERE pid = :pid";
        $statement = $connection->prepare($query);
        $statement->bindParam(":pid", $_GET['pid']);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetch();
        $dir = $result['post'];
        delete_directory($dir);
        
        $query = "DELETE FROM post WHERE pid = :pid";
        $statement = $connection->prepare($query);
        $statement->bindParam(":pid", $_GET['pid']);
        $statement->execute();
    }
    catch (PDOException $ex)
    {
        Logger::write_log("deletepost.php", $ex->getMessage());
    }
}

function delete_directory($path)
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
            delete_directory($file);
        }
        else
        {
            unlink($file);
        }
    }
    
    rmdir($path);
}

