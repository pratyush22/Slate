<?php

include "./library/autoload.php";
include "./library/security.php";

function get_likes($pid)
{
    $likes = 0;
    
    try
    {
        $db = new DatabaseConnection();
        $connection = $db->get_connection();
        $query = "SELECT likes FROM post WHERE pid = :pid";
        $statement = $connection->prepare($query);
        $statement->bindParam(":pid", $pid);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetch();
        
        if ($result)
        {
            $likes = $result["likes"];
        }
        
        $statement = null;
        $connection = null;
    }
    catch (Exception $ex)
    {
        Logger::write_log("likepost.php", $ex->getMessage());
    }
    
    return $likes;
}

function increment_likes($pid, $likes)
{
    $likes++;
    
    try
    {
        $db = new DatabaseConnection();
        $connection = $db->get_connection();
        $query = "UPDATE post SET likes = :likes WHERE pid = :pid";
        $statement = $connection->prepare($query);
        $statement->bindParam(":likes", $likes);
        $statement->bindParam(":pid", $pid);
        $statement->execute();
        
        $statement = null;
        $connection = null;
    }
    catch (Exception $ex)
    {
        Logger::write_log("likepost.php", $ex->getMessage());
    }
}

$pid = $_GET["pid"];
$likes = get_likes($pid);
increment_likes($pid, $likes);
