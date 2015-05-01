<?php

include "./library/security.php";
include "./library/autoload.php";

$query = "SELECT * FROM answer WHERE qid = :qid ORDER BY aid DESC";

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    try
    {
        $db = new DatabaseConnection();
        $connection = $db->get_connection();
        $statement = $connection->prepare($query);
        $statement->bindParam(":qid", $_GET['qid']);
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $ans)
        {
?>

<div class="answer-block">
    <div class="answer-text"><?php echo $ans['ans'];?></div>
    <div class="answer-info">
        <span>by <?php echo $ans['name'];?></span>
    </div>
</div>
<br />

<?php
        }
    }
    catch (Exception $ex)
    {
        Logger::write_log("displayanswers.php", $ex->getMessage());
    }
}