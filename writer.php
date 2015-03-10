<!DOCTYPE html>
<?php
    include "./library/autoload.php";
    include "./library/security.php"
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Slate: Writer</title>
        <link rel="stylesheet" href="./css/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/stylesheet_1.css">
        <script src="/js/jquery.js"></script>
        <script src="./css/dist/js/bootstrap.min.js"></script>
        <script src="./js/script_1.js"></script>
        <script src="./epiceditor/js/epiceditor.min.js"></script>
    </head>
    <body>
        <?php include "./navigation.php"; ?>
        
        <main class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div id="epiceditor" class="EpicEditorCustom">
                        
                    </div>
                </div>
            </div>
            
            <script type="text/javascript">
                var editor = getEpicEditorForWriting();
                editor.load();
            </script>
        </main>
    </body>
</html>
