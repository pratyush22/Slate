<?php

include "./library/security.php";
include "./library/autoload.php";

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
    $quest = new Question();
    $quest->get_question_from_database($_GET['qid']);
}

?>

<!DOCTYPE html>
<html>
     <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Slate</title>
        <link rel="stylesheet" href="./css/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/stylesheet_1.css">
        <script src="./js/jquery.js"></script>
        <script src="./css/dist/js/bootstrap.min.js"></script>
        <script src="./js/script_1.js"></script>
    </head>
    <body>
        <?php include "./navigation.php";?>
        
        <div class="container">
            <div class="quest-block">
                <div class="quest-title"><?php echo $quest->get_question();?></div>
                <div class="quest-description"><?php echo $quest->get_description();?></div>
                <div class="quest-info">
                    <label>by <?php echo $quest->get_name();?></label>
                </div>
            </div>
            
            <div class="">
                <br />
                <span class="text-info" style="font-size: 1.2em;">Write answer</span>
                <br />
                <textarea id="ans" style="resize: none; height: 100px; width: 50%;"
                          placeholder="Write your answer here"></textarea>
                <input id="name" type="hidden" value="<?php echo $_SESSION['name']?>" />
                <input id="qid" type="hidden" value="<?php echo $quest->get_qid();?>" />
                <br />
                <button class="btn btn-success" onclick="writeAnswer()">Answer</button>
            </div>
            <hr />
            
            
            
            <div id="display-answers">
                
            </div>
        </div>
        
        <script>
            displayAnswers(<?php echo $quest->get_qid();?>)
        </script>
        
        <br />
        <?php include "./footer.php"?>
    </body>
</html>