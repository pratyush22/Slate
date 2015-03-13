<?php

include "./library/autoload.php";
include "./library/security.php";

$query = "SELECT title, pid, likes, state FROM post WHERE uid = :uid";
$pid = "";
$title = "";
$likes = "";
$state = "";
$user = new User();
$user->set_details_from_database($_SESSION['username']);
$uid = $user->get_id();

try
{
    
    $db = new DatabaseConnection();
    $connection = $db->get_connection();
    $statement = $connection->prepare($query);
    $statement->bindParam(":uid", $uid);
    $statement->execute();

    //$statement->setFetchMode(PDO::FETCH_ASSOC);

    foreach ($statement->fetchAll() as $post)
    {
        $title = $post['title'];
        $likes = $post['likes'];
        $state = $post['state'];
        $pid = $post['pid'];
?>

<div class="post-list">
    <form>
        <input id="<?php echo $pid;?>" type="hidden" value="<?php echo $pid;?>" />
    </form>
    
    <span><h2>Title:&nbsp</h2><?php echo $title;?></span>
    
    <div class="pull-left">
        <a onclick="">Edit</a> | 
        <a>View</a> | 
        <a onclick="deletePost(<?php echo $pid;?>)">Delete</a>
    </div>
    
    <div class="pull-right">
        <label><?php echo $likes." likes"?></label> | 
        <label><?php echo $state;?></label>
    </div>
    
    <div class="clearfix"></div>
</div>

<?php
    }

    $statement = null;
    $connection = null;
}
catch (PDOException $ex)
{
    Logger::write_log("myposts.php", $ex->getMessage());
}

?>