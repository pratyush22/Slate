<?php

include "./library/autoload.php";
include "./library/security.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $title = $_POST["title"];
    $content = $_POST["content"];
    $pid = $_POST["pid"];
    $uid = $_POST["uid"];
    
    try
    {
        $db = new DatabaseConnection();
        $connection = $db->get_connection();
        $query = "UPDATE post SET title = :title WHERE pid = :pid";
        $statement = $connection->prepare($query);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":pid", $pid);
        $statement->execute();
        $statement = null;
        $connection = null;
        
        $path = "./data/".$uid."/".$pid."/post.md" or die("Unable to open");
        $file = fopen($path, "w");
        fwrite($file, $content);
        fclose($file);
    }
    catch (PDOException $ex)
    {
        Logger::write_log("savepost.php", $ex->getMessage());
    }
}