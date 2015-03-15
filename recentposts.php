<?php

include "./library/autoload.php";
include "./library/security.php";

function get_user_name($uid)
{
    $name = "";
    
    try
    {
        $db = new DatabaseConnection();
        $connection = $db->get_connection();
        $query = "SELECT name FROM user WHERE id = :uid";
        $statement = $connection->prepare($query);
        $statement->bindParam(":uid", $uid);
        $statement->execute();
        $result = $statement->fetch();
        
        if ($result)
        {
            $name = $result["name"];
        }
        
        $statement = null;
        $connection = null;
    }
    catch (Exception $ex)
    {
        Logger::write_log("recentpost.php", $ex->getMessage());
    }
    
    return $name;
}

try
{
    $state = "published";
    $db = new DatabaseConnection();
    $connection = $db->get_connection();
    $pquery = "SELECT pid, uid, title, likes FROM post WHERE state = :state ORDER BY pid DESC";
    $statement = $connection->prepare($pquery);
    $statement->bindParam(":state", $state);
    $statement->execute();
    $posts = $statement->fetchAll();

    foreach ($posts as $post)
    {
        $pid = $post["pid"];
        $uid = $post["uid"];
        $title = $post["title"];
        $likes = $post["likes"];
        $name = get_user_name($uid);
?>

<div class="post-list">
    <div>
        <a><h2 style="display: inline;" class="text-info"><?php echo $title;?></h2></a>
        
        <div class="pull-right">
        <span style="font-size: 1.6em;"><?php echo $likes;?>&nbsp;<span class="glyphicon glyphicon-thumbs-up"></span></span>
        </div>
        
        <div class="clearfix"></div>
    </div>
    
    <label>(by&nbsp;&nbsp;<?php echo$name;?>)</label>
</div>

<?php
    }
}
catch (Exception $ex)
{
    Logger::write_log("recentpost.php", $ex->getMessage());
}