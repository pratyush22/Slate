<?php

include "./library/autoload.php";
include "./library/security.php";

$pid = $_GET["pid"];

$post = new Post();
$post->get_post($pid, null);

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
                <div class="col-sm-1">
                    
                </div>
                
                <div class="col-sm-8">
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