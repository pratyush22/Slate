<?php
    include "./library/security.php";
    include "./library/autoload.php";
    
    $user = new User();
    $user->set_details_from_database($_SESSION['username']);
    
    $question = "";
    $description = "";
    $qid = "";
    $action = "Start";
    $url = "./creatediscuss.php";
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $quest = new Question();
        $quest->get_question_from_database($_GET['qid']);
        $question = $quest->get_question();
        $description = $quest->get_description();
        $action = "Save";
        $url = "./updatediscuss.php";
        $qid = $_GET['qid'];
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>New Discussion</title>
        <link rel="stylesheet" href="./css/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/stylesheet_1.css">
        <script src="./js/jquery.js"></script>
        <script src="./css/dist/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php include "navigation.php"; ?>
        
        <div class="container">
            <div>
                <h1 class="text-info">Start a new Discussion</h1>
                <hr />
            </div>
            
            <div class="form-group-lg">
                <form action="<?php echo $url;?>" method="post" role="form">
                    <input name="question" class="form-control" type="text"
                           required placeholder="Question or Query" value="<?php echo $question;?>" />
                    <br />
                    <textarea name="description" class="form-control" style="height: 300px; resize: none;"
                              placeholder="Description"><?php echo $description;?></textarea> <br />
                    <input type="hidden" name="qid" value="<?php echo $qid;?>" />
                    <input type="hidden" name="uid" value="<?php echo $user->get_id();?>" />
                    <input type="hidden" name="name" value="<?php echo $_SESSION['name']?>" />
                    <button class="btn btn-success btn-lg"><?php echo $action;?></button> &nbsp;
                    <a href="dashboard.php" class="btn btn-danger btn-lg">Cancel</a>
                </form>
            </div>
        </div>
        
        <br />
        <?php include "footer.php";?>
    </body>
</html>