<?php
    include "library/security.php";
    $name = $_SESSION["name"];
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
                    <figure>
                        <img id="user_pic" src="./images/Icon-user.png" width="150" height="150"
                             class="img-rounded" alt="Profile pic" />
                        <br />
                        <br />
                        <input id="file_upload" onchange="showImage()" type="file" form="info" />
                        <hr />
                    </figure>
                    
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
                              method="post" role="form" id="info">
                            <span class="text-danger"></span>
                            <span class="text-success"><?php?></span>
                            <br />
                            <label>Full Name</label>
                            <input type="text" name="name" required="required"
                                   class="form-control" value="<?php echo $name?>" />
                            <br />
                            <label>Username</label>
                            <input type="text" name="username" required="required"
                                   class="form-control" value="<?php echo $username?>"
                                   disabled="disabled" />
                            <br />
                            <label>e-mail</label>
                            <input type="email" name="email" required="required"
                                   class="form-control" value="<?php echo $email?>"
                                   disabled="disabled" />
                            <br />
                            <label for="male" class="form-inline">Male</label>&nbsp;
                            <input type="radio" id="male" name="gender" 
                                   class="form-inline" value="male" />&nbsp;&nbsp;
                            <label for="female" class="form-inline">Female</label>&nbsp;
                            <input type="radio" id="female" name="gender"
                                   class="form-inline" value="female" />
                            <br /><br />
                            <label>About me</label>
                            <textarea class="form-control"></textarea>
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
                            <span class="text-danger"></span>
                            <span class="text-success"></span>
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
