<?php

include "./library/security.php";
include "./library/autoload.php";

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    $quest = new Question();
    $quest->set_name($_POST['name']);
    $quest->set_uid($_POST['uid']);
    $quest->set_question($_POST['question']);
    $quest->set_description($_POST['description']);
    $quest->create_new_question();
}

header("Location: ./dashboard.php");