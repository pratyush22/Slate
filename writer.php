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
                <div class="col-sm-1">
                    <br /><br />
                    <div class="btn-group-vertical">
                        <button class="btn btn-success btn-block">Save</button>
                        <button name="preview" class="btn btn-default">Preview</button>
                        <button name="clear" class="btn btn-default">Clear</button>
                    </div>
                </div>
                
                <div class="col-sm-8">
                    <label class="text-danger"></label>
                    <label class="text-success"></label>
                    
                    <div class="form-group">
                        <form role="form">
                            <input type="text" name="title" required="required"
                                   class="form-control" placeholder="Title"/>
                            <textarea id="text" style="display:none;"></textarea>
                        </form>
                    </div>
                    
                    <div id="epiceditor" oninput="countCharacters()" class="EpicEditorCustom">
                        
                    </div>
                    <br />
                    
                    <div class="btn-group">
                        <button class="btn btn-success">Save</button>
                        <button name="preview" class="btn btn-default">Preview</button>
                        <button name="clear" class="btn btn-default">
                            Clear
                        </button>
                    </div>
                </div>
            </div>
            
            <script type="text/javascript">
                var editor = getEpicEditorForWriting();
                editor.load();
            </script>
        </main>
        
        <?php include "footer.php";?>
    </body>
</html>
