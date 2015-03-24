<?php

include "./library/security.php";

function create_file($path)
{
    $file = fopen($path, "w");
    fprintf($file, "%d\n", 0);
    fclose($file);
}

function get_image_index($path)
{
    $index = "";
    $file = fopen($path, "r");
    $index = fscanf($file, "%d");
    fclose($file);
    $index = $index[0];
    $index++;
    return $index;
}

function save_path($dir, $path, $meta, $index)
{
    $path_file = $dir."/paths";
    $file = fopen($path_file, "a");
    fprintf($file, "%s\n", $path);
    fclose($file);
    
    $file = fopen($meta, "w");
    fprintf($file, "%d\n", $index);
    fclose($file);
}


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $uid = $_POST["uid"];
    $pid = $_POST["pid"];
    
    if (empty($_FILES["image"]["name"]))
    {
        echo "Select a file to upload.";
        exit();
    }
    
    $dir_path = "./data/".$uid."/".$pid."/images";
    if (!file_exists($dir_path))
    {
        mkdir($dir_path);
    }
    
    $meta_file_path = $dir_path."/"."meta";
    if (!file_exists($meta_file_path))
    {
        create_file($meta_file_path);
    }
    
    $next_image_index = get_image_index($meta_file_path);
    
    //  File uploading starts here
    $final_path = $dir_path."/".$next_image_index.".png";
    
    $uploadOk = 1;
    $error = "";
    
    $imageFileType = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);
    
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false)
    {
        $uploadOk = 1;
    }
    else
    {
        $uploadOk = 0;
        $error = "File is not an Image";
    }
    
    //  Check file size
    if ($_FILES["image"]["size"] > 500000)
    {
        $error = "File too large";
        $uploadOk = 0;
    }
    
    //  Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" 
            && $imageFileType != "gif" )
    {
        $error = "File format not allowed";
        $uploadOk = 0;
    }
    
    if ($uploadOk == 0)
    {
        echo "File not uploaded";
    }
    else
    {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $final_path))
        {
            save_path($dir_path, $final_path, $meta_file_path, $next_image_index);
            echo "File uploaded";
        }
        else
        {
            echo "File not uploaded";
        }
    }
}

