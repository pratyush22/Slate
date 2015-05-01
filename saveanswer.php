<?php

include "./library/security.php";
include "./library/autoload.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $answer = $_POST['ans'];
    $name = $_POST['name'];
    $qid = $_POST['qid'];
    
    $query = "INSERT INTO answer(qid, name, ans) VALUES("
            . ":qid, :name, :answer)";
    
    echo "in here";
    
    try
    {
        $db = new DatabaseConnection();
        $connection = $db->get_connection();
        $statement = $connection->prepare($query);
        $statement->bindParam(":qid", $qid);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":answer", $answer);
        $statement->execute();
        
        $statement = null;
        $connection = null;
    }
    catch (Exception $ex)
    {
        Logger::write_log("saveanswer.php", $ex->getMessage());
    }
}