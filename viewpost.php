<?php

include "./library/autoload.php";
include "./library/security.php";

$pid = $_GET["pid"];
$uid = $_GET["uid"];

$post = new Post();
$post->get_post($pid, null);

$user = new User();
$user->set_min_details($uid);

?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Slate: Viewer</title>
        <link rel="stylesheet" href="./css/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/stylesheet_1.css">
        <script src="/js/jquery.js"></script>
        <script src="./css/dist/js/bootstrap.min.js"></script>
        <script src="./js/script_1.js"></script>
        <script src="./epiceditor/js/epiceditor.min.js"></script>
    </head>
    <body>
        
        <?php include "./navigation.php";?>
        
        <main class="container" style="min-height: 500px;">
            <div class="row">
                <div class="col-sm-2">
                    <figure>
                        <img src="<?php echo $user->get_image();?>" alt="Author"
                             class="img-responsive img-rounded" width="80%" />
                    </figure>
                    <br />
                    <label><?php echo $user->get_name();?></label><br />
                    <span><?php echo $user->get_about();?></span>
                    <hr />
                    <button onclick="likePost(<?php echo $pid;?>)" class="btn btn-success">
                        <span class="glyphicon glyphicon-thumbs-up"></span>
                        Like
                    </button>
                </div>
                
                <div class="col-sm-10">
                    <div class="post-title">
                        <h1 class="text-info"><?php echo $post->get_title();?></h1>
                    </div>
                    <textarea id="text" disabled="disabled" style="display: none;"><?php echo $post->get_post_content();?></textarea>

                    <div id="epiceditor"></div>
                </div>
            </div>
            
            <script type="text/javascript">
                loadEpicEditor();
            </script>
        </main>
        
        <?php include "./footer.php";?>
    </body>
</html>