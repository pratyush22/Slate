<?php

include "./library/security.php";
include "./library/autoload.php";

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
    $query = "DELETE FROM quest WHERE qid = :qid";
    
    try
    {
        $db = new DatabaseConnection();
        $connection = $db->get_connection();
        $statement = $connection->prepare($query);
        $statement->bindParam(":qid", $_GET['qid']);
        $statement->execute();
        
        $statement = null;
        $connection = null;
    }
    catch (Exception $ex)
    {
        Logger::write_log("deletediscussion.php", $ex->getMessage());
    }
    
    $query = "DELETE FROM answer WHERE qid = :qid";
    
    try
    {
        $db = new DatabaseConnection();
        $connection = $db->get_connection();
        $statement = $connection->prepare($query);
        $statement->bindParam(":qid", $_GET['qid']);
        $statement->execute();
        
        $statement = null;
        $connection = null;
    }
    catch (Exception $ex)
    {
        Logger::write_log("deletediscussion.php", $ex->getMessage());
    }
}