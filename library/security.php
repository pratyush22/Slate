<?php
    session_start();
    //  No caching
    header("Cache-Control: no cache, must-revalidate"); //  HTTP 1.1
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");   //  Date in the past
    
    if (empty($_SESSION["username"]))
    {
        header("Location: ../index.php");
        exit();
    }
?>
