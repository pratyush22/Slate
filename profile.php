<?php
    include "library/security.php";
    include "library/autoload.php";
    
    //  Success and Error messages for password changing operation
    $pass_success = "";
    $pass_error = "";
    
    //  Success and Error messages for information changing operation
    $info_success = "";
    $info_error = "";
    
    $user = new User();
    $user->set_details_from_database($_SESSION["username"]);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if ($_POST["action"] == "delete")
        {
            //  If deletion of account is successful then logout
            //  from the application
            if ($user->delete_account())
            {
                include "logout.php";
            }
        }
        else if ($_POST["action"] == "info")
        {
            $user->set_name($_POST["name"]);
            
            if (!empty($_POST["gender"]))
            {
                $user->set_gender($_POST["gender"]);
            }
            
            if (!empty($_POST["about"]))
            {
                $user->set_about($_POST["about"]);
            }
            
            //  Upload Image if available
            if (isset($_FILES["user_image"]))
            {
                $target_dir = "images/users/";
                
                //  If directory do not exist then create one
                if (!file_exists($target_dir))
                {
                    mkdir($target_dir);
                }
                
                $target_file = $target_dir.$user->get_id();
                $uploadOK = 1;
                $image_file_type = pathinfo($_FILES["user_image"]["name"], PATHINFO_EXTENSION);
                
                //  Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["user_image"]["tmp_name"]);
                if ($check !== false)
                {
                    $uploadOK = 1;
                }
                else
                {
                    $info_error = "File is not an image";
                    $uploadOK = 0;
                }
                
                //  Check file size (1MB)
                if ($_FILES["user_image"]["size"] > 1000000)
                {
                    $info_error = "File is too large (should be less than 1MB)";
                    $uploadOK = 0;
                }
                
                //  Check file formats
                if ($image_file_type != "jpg" && $image_file_type != "png" &&
                        $image_file_type != "jpeg" && $image_file_type != "gif")
                {
                    $info_error = "Only JPEG, PNG and GIF format is allowed";
                    $uploadOK = 0;
                }
                
                //  If everything is fine then save the image
                if ($uploadOK != 0)
                {
                    if (move_uploaded_file($_FILES["user_image"]["tmp_name"], $target_file))
                    {
                        $user->set_image($target_file);
                    }
                    else
                    {
                        $info_error = "Sorry, there was an error uploading your file";
                    }
                }
            }
            
            //  If changes are made successfully then write a success message
            //  and update the session variables.
            if ($user->save_changes())
            {
                $info_success = "Saved";
                $_SESSION["username"] = $user->get_username();
                $_SESSION["name"] = $user->get_name();
            }
            else
            {
                $info_error = $user->get_error();
            }
        }
        else if ($_POST["action"] == "password")
        {
            if ($user->change_password($_POST["old_password"], $_POST["new_password"], $_POST["confirm_new_password"]))
            {
                $pass_success = "Password changed";
            }
            else
            {
                $pass_error = $user->get_error();
            }
        }
    }
    
    //  For setting the gender options
    $gender = $user->get_gender();
    $male = "";
    $female = "";
    
    if (!strcmp($gender, "male"))
    {
        $male = "checked";
    }
    else if (!strcmp($gender, "female"))
    {
        $female = "checked";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Profile</title>
        <link rel="stylesheet" href="./css/dist/css/bootstrap.min.css">
        <script src="js/script_1.js"></script>
        <script src="/js/jquery.js"></script>
        <script src="./css/dist/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php include "navigation.php";?>
        
        <main class="container">
            <div class="row">
                <div class="col-sm-4">
                    
                    <!-- Image file upload belong to personal information form -->
                    <figure>
                        <img id="user_pic" src="<?php echo $user->get_image();?>" width="150" height="150"
                             class="img-rounded" alt="Profile pic" />
                        <br />
                        <br />
                        
                        <input id="file_upload" name="user_image" onchange="showImage()" type="file" form="info" />
                        <hr />
                    </figure>
                    
                    <!-- Delete account form -->
                    <div class="form-group">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                              method="post" role="form" onsubmit="return deleteAccount()">
                            <input type="hidden" name="action" value="delete" />
                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span>&nbsp;
                                Delete account
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="col-sm-6">
                    
                    <!-- Personal information form -->
                    <div class="form-group">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                              method="post" role="form" id="info" enctype="multipart/form-data">
                            <span class="text-danger"><?php echo $info_error;?></span>
                            <br />
                            <span class="text-success"><?php echo $info_success;?></span>
                            <br />
                            
                            <label>Full Name</label>
                            <input type="text" name="name" required="required"
                                   class="form-control" value="<?php echo $user->get_name();?>" />
                            <br />
                            
                            <label>Username</label>
                            <input type="text" name="username" required="required"
                                   class="form-control" value="<?php echo $user->get_username();?>"
                                   disabled="disabled" />
                            <br />
                            
                            <label>e-mail</label>
                            <input type="email" name="email" required="required"
                                   class="form-control" value="<?php echo $user->get_email();?>"
                                   disabled="disabled" />
                            <br />
                            
                            <label for="male" class="form-inline">Male</label>&nbsp;
                            <input type="radio" id="male" name="gender" <?php echo $male;?> 
                                   class="form-inline" value="male" />&nbsp;&nbsp;
                            <label for="female" class="form-inline">Female</label>&nbsp;
                            <input type="radio" id="female" name="gender" <?php echo $female;?>
                                   class="form-inline" value="female" />
                            <br /><br />
                            
                            <label>About me</label>
                            <textarea name="about" class="form-control"><?php echo $user->get_about()?></textarea>
                            <br />
                            
                            <input type="hidden" name="action" value="info" />
                            <input type="submit" class="btn btn-success" value="Save" />
                        </form>
                    </div>
                    <hr />
                    
                    <!-- Password changing form -->
                    <div class="form-group">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
                              method="post" role="form">
                            <span class="text-danger"><?php echo $pass_error;?></span>
                            <span class="text-success"><?php echo $pass_success;?></span>
                            <br />
                            
                            <label>Old password</label>
                            <input type="password" name="old_password" required="required"
                                   class="form-control" />
                            <br />
                            
                            <label>New password</label>
                            <input type="password" name="new_password" required="required"
                                   class="form-control" />
                            <br />
                            
                            <label>Confirm new password</label>
                            <input type="password" name="confirm_new_password" required="required"
                                   class="form-control" />
                            <input type="hidden" name="action" value="password" />
                            <br />
                            
                            <input type="submit" class="btn btn-success" value="Change password" />
                        </form>
                    </div>
                </div>
            </div>
        </main>
        
        <?php include "footer.php";?>
    </body>
</html>
