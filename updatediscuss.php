<?php

include "./library/security.php";
include "./library/autoload.php";

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    $quest = new Question();
    $quest->set_description($_POST['description']);
    $quest->set_question($_POST['question']);
    $quest->update_question($_POST['qid']);
}

header("Location: ./dashboard.php");