<?php
    include "./library/security.php";
    include "./library/autoload.php";
    
    $user = new User();
    $user->set_details_from_database($_SESSION["username"]);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>
        <link rel="stylesheet" href="./css/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/stylesheet_1.css" >
        <script src="/js/jquery.js"></script>
        <script src="./css/dist/js/bootstrap.min.js"></script>
        <script src="./js/script_1.js"></script>
    </head>
    <body>
        <?php include "navigation.php";?>
        
        <!-- Form for redirecting -->
        <form id="operation" method="post">
            <input name="action" type="hidden" value="" />
        </form>
        
        <main class="row container">
            <!-- Left pane -->
            <div class="col-sm-2">
                <figure style="margin-bottom: 5px;">
                    <img src="<?php echo $user->get_image();?>" alt="User Image"
                         width="150" height="150" class="img-thumbnail" />
                </figure>
                
                <span class="large-font-1-2"><?php echo $user->get_name();?></span>
                <br />
                <br />
                
                <button class="btn btn-default btn-block large-font-1-2" onclick="recentPosts()">Recent Posts</button>
                <button class="btn btn-default btn-block large-font-1-2" onclick="redirect('new', 'writer.php')">New Post</button>
                <button class="btn btn-default btn-block large-font-1-2" onclick="getMyPosts()">My Posts</button>
            </div>
            
            <!-- Middle Column -->
            <div class="col-sm-8">
                <div id="display-container">
                    <div class="nothing">Nothing to display</div>
                </div>
            </div>
            
            <script>
                recentPosts();
            </script>
        </main>
    </body>
</html>
