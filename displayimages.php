<?php

include "./library/security.php";

$uid = $_GET["uid"];
$pid = $_GET["pid"];

$path = "./data/".$uid."/".$pid."/images/paths";
if (!file_exists($path))
{
    exit();
}

$file = fopen($path, "r") or die("Unable to open file");

while (!feof($file))
{
    $img = fgets($file);
    
    if (empty($img))
    {
            continue;
    }
    
    $markdown = "![Alt-Text](".$img.")";
?>

<div class="img-display">
    <figure>
        <figcaption style="text-align: center; margin: 2px;"><?php echo $markdown;?></figcaption>
        <image src="<?php echo $img;?>" width="100%" />
    </figure>
</div>

<?php
}

fclose($file);