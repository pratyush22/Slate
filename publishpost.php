<?php

include "./library/autoload.php";
include "./library/security.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $pid = $_POST["pid"];
    
    $post = new Post();
    if ($post->publish_post($pid))
    {
        echo "Revert Post";
    }
}