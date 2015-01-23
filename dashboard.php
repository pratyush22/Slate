<?php
    include "./library/security.php";
    $username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>
        <link rel="stylesheet" href="./css/dist/css/bootstrap.min.css">
        <script src="/js/jquery.js"></script>
        <script src="./css/dist/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php include "navigation.php";?>
    </body>
</html>
