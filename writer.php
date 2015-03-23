<!DOCTYPE html>
<?php
    include "./library/autoload.php";
    include "./library/security.php";
    
    $pid = "";
    $uid = "";
    $title = "";
    $content = "";
    $state = "draft";
    $function = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if ($_POST["action"] == "new")
        {
            $post = new Post();
            $post->create_new_post($_SESSION['username']);
            $pid = $post->get_pid();
            $uid = $post->get_uid();
        }
        else if ($_POST["action"] == "edit")
        {
            $post = new Post();
            $post->get_post($_POST["pid"], $_POST["uid"]);
            $pid = $post->get_pid();
            $uid = $post->get_uid();
            $title = $post->get_title();
            $content = $post->get_post_content();
            $state = $post->get_state();
        }
        else
        {
            header("Location: dashboard.php");
            exit();
        }
    }
    
    if ($state == "draft")
    {
        $state = "Publish Post";
        $function = "publishPost(this)";
    }
    else if ($state == "published")
    {
        $state = "Revert Post";
        $function = "revertPost(this)";
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Slate: Writer</title>
        <link rel="stylesheet" href="./css/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/stylesheet_1.css">
        <script src="./js/jquery.js"></script>
        <script src="./css/dist/js/bootstrap.min.js"></script>
        <script src="./js/script_1.js"></script>
        <script src="./epiceditor/js/epiceditor.min.js"></script>
    </head>
    <body>
        <?php include "./navigation.php"; ?>
        
        <!-- Bottom control menu -->
        <div class="writer-bottom-menu">
            <div class="pull-left">
                <div class="btn-group">
                    <button id="save" class="btn btn-success">Save</button>
                    <button id="preview" class="btn btn-default">Toggle Preview</button>
                    <button id="clear" class="btn btn-default">Clear</button>
                    <button id="full" class="btn btn-default">Full Screen</button>
                    <button class="btn btn-default" onclick="<?php echo $function;?>"><?php echo $state;?></button>
                </div>
            </div>
            
            <div class="pull-right">
                <div id="char-left" style="color: white; font-size: 1em">5000 Left</div>
            </div>
        </div>
        
        <main class="container">
            <div class="row">
                
                <!-- Editor Column -->
                <div class="col-sm-8">
                    <label class="text-danger"></label>
                    <label class="text-success"></label>
                    
                    <div class="form-group">
                        <form id="save" role="form">
                            <input type="text" id="title"
                                   class="form-control" placeholder="Title" value="<?php echo $title;?>"/>
                            <textarea disabled="disabled" id="text" name="post" style=""><?php echo $content;?></textarea>
                            <input type="hidden" id="uid" value="<?php echo $uid;?>" />
                            <input type="hidden" id="pid" value="<?php echo $pid;?>" />
                        </form>
                    </div>
                    
                    <div id="epiceditor" class="EpicEditorCustom">
                        
                    </div>
                    <br />
                </div>
                
                <!-- Second column -->
                <div class="col-sm-4">
                    <!-- Image uploading block -->
                    <div class="img-upload-block">
                        <span class="text-info text-center">
                            <h3>Upload Image</h3>
                        </span>
                        <hr />
                        
                        <form id="image-form" onsubmit="return false;" method="post" enctype="multipart/form-data">
                            <input id="image" type="file" name="image" />
                            <input type="hidden" id="pid" name="pid" value="<?php echo $pid;?>" />
                            <input type="hidden" id="uid" name="uid" value="<?php echo $uid;?>" />
                            <br />
                            <button class="btn btn-success btn-sm"
                                    onclick="uploadImage()">Upload</button>&nbsp;
                            <label>Status:</label> <span id="message">Nothing to upload</span>
                        </form>
                    </div>
                    <hr />
                    
                    <div id="image-display">
                        
                    </div>
                    
                    <script type="text/javascript">
                        var pid = <?php echo $pid;?>;
                        var uid = <?php echo $uid;?>;
                        displayImages(pid, uid);
                    </script>
                </div>
            </div>
            
            <script type="text/javascript">
                getEpicEditorForWriting();
            </script>
        </main>
        
        <?php include "footer.php";?>
    </body>
</html>
