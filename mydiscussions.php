<div>
    <h1 class="text-info">My Discussions</h1>
    <hr />
</div>

<?php

include "./library/security.php";
include "./library/autoload.php";

$user = new User();
$user->set_details_from_database($_SESSION["username"]);
$query = "SELECT qid, question FROM quest WHERE uid = :uid";

try
{
    $db = new DatabaseConnection();
    $connection = $db->get_connection();
    $statement = $connection->prepare($query);
    $statement->bindParam(":uid", $user->get_id());
    $statement->execute();
    $questions = $statement->fetchAll();
    
    foreach ($questions as $quest)
    {
?>

<div class="post-list">
    <h3><?php echo $quest['question'];?></h3>
    <a href="displaydiscussion.php?qid=<?php echo $quest['qid'];?>">View</a>&nbsp;|
    <a href="newdiscussion.php?qid=<?php echo $quest['qid'];?>">Edit</a>&nbsp;|
    <a onclick="deleteDiscussion(<?php echo $quest['qid'];?>)">Delete</a>&nbsp;
</div>

<?php
    }
}
catch (PDOException $ex)
{
    Logger::write_log("mydiscussions.php", $ex->getMessage());
}