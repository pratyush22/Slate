<?php
    session_start();
    include "./library/autoload.php";

    $login_error = "";
    $signup_error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if ($_POST["action"] == "signup")
        {   
            $signup = new Signup();
            $signup->set_name($_POST["name"]);
            $signup->set_email($_POST["email"]);
            $signup->set_password($_POST["password"]);
            $signup->set_confirm_password($_POST["confirm_password"]);
            
            if (!$signup->signup())
                $signup_error = $signup->get_error();
            else
                login($signup->get_username());
        }
        else if ($_POST["action"] == "login")
        {
            $login = new Login();
            $login->set_email($_POST["email"]);
            $login->set_password($_POST["password"]);
            
            if (!$login->login())
                $login_error = $login->get_error ();
            else
            {
                echo "Login successful, username is ".$login->get_username()." //";
                exit();
                login($login->get_username());
            }
        }
    }
    
    function login($username)
    {
        $_SESSION["username"] = $username;
        session_write_close();
        header("Location: ./dashboard.php");
        exit();
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
        <script src="/js/jquery.js"></script>
        <script src="./css/dist/js/bootstrap.min.js"></script>
    </head>
    <body>
        <!--
          Header containing site's name and
          login block.
        -->
        <header class="container page-header">
            <div class="pull-left">
                <h1>Slate</h1>
            </div>
            
            <!-- Login form -->
            <div class="pull-right col-sm-6">
                <div class="form-group">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                          method="post" role="form" class="form-inline">
                        <span class="text-danger"><?php echo $login_error; ?></span>
                        <br />
                        <input type="email" name="email" required="required"
                               placeholder="Your email" class="form-control"/>
                        <input type="password" name="password" required="required"
                               placeholder="Your password" class="form-control" />
                        <input type="hidden" name="action" value="login" />
                        <button type="submit" class="btn btn-success">Login</button>
                    </form>
                </div>
            </div>
            
            <div class="clearfix"></div>
        </header>
        
        <main class="container">
            <div class="jumbotron custom-jumbotron">
                <div class="pull-left col-sm-4">
                    <h2>Express yourself</h2>
                    <p>
                        Share your views by writing posts. Express
                        yourself through images. Discuss and clarify your doubts.
                    </p>
                </div>
                
                <!-- Signup form -->
                <div class="pull-right col-sm-4">
                    <div class="form-group">
                        <h3>
                            <span class="text-center text-info">
                                Signup for Slate
                            </span>
                        </h3>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                              method="post" role="form">
                            <span class="text-danger"><?php echo $signup_error?></span>
                            <input type="hidden" name="action" value="signup" />
                            <input type="text" name="name" required="required"
                                   placeholder="Your full name" class="form-control"/><br />
                            <input type="email" name="email" required="required"
                                   placeholder="Your email" class="form-control"/><br />
                            <input type="password" name="password" required="required"
                                   placeholder="Password" class="form-control"/><br />
                            <input type="password" name="confirm_password" required="required"
                                   placeholder="Confirm password" class="form-control"/><br />
                            <input type="submit" class="btn btn-success" value="Signup" />
                        </form>
                    </div>
                </div>
                
                <div class="clearfix"></div>
            </div>
        </main>
        
        <?php include "footer.php"; ?>
    </body>
</html>
