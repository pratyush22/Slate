<div>
    <h1 class="text-info">Current Discussions</h1>
    <hr />
</div>

<?php

include "./library/security.php";
include "./library/autoload.php";

$query = "SELECT qid, name, question FROM quest";

try
{
    $db = new DatabaseConnection();
    $connection = $db->get_connection();
    $statement = $connection->prepare($query);
    $statement->execute();
    
    $result = $statement->fetchAll();
    foreach ($result as $quest)
    {
        $name = $quest["name"];
        $question = $quest["question"];
        $qid = $quest["qid"];
?>

<div class="post-list">
    <h2><a href="displaydiscussion.php?qid=<?php echo $qid;?>"><?php echo $question;?></a></h2>
    <label>by <?php echo $name;?></label>
</div>

<?php
    }
}
catch (Exception $ex)
{
    Logger::write_log("discussionlist.php", $ex->getMessage());
}
