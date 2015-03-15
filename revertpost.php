<?php

include "./library/autoload.php";
include "./library/security.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $pid = $_POST["pid"];
    $post = new Post();
    
    if ($post->revert_post($pid))
    {
        echo "Publish Post";
    }
}