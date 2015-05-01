<?php

class Question
{
    private $qid;
    private $uid;
    private $name;
    private $question;
    private $description;
    
    function __construct()
    {
        $this->description = "";
        $this->qid = "";
        $this->question = "";
        $this->name = "";
        $this->uid = "";
    }
    
    public function set_qid($qid)
    {
        $this->qid = $qid;
    }
    
    public function get_qid()
    {
        return $this->qid;
    }
    
    public function set_uid($uid)
    {
        $this->uid = $uid;
    }
    
    public function get_uid()
    {
        return $this->uid;
    }
    
    public function set_name($name)
    {
        $this->name = $name;
    }
    
    public function get_name()
    {
        return $this->name;
    }
    
    public function set_question($question)
    {
        $this->question = $question;
    }
    
    public function get_question()
    {
        return $this->question;
    }
    
    public function set_description($description)
    {
        $this->description = $description;
    }
    
    public function get_description()
    {
        return $this->description;
    }
    
    public function create_new_question()
    {
        $query = "INSERT INTO quest(uid, name, question, description) VALUES("
                . ":uid, :name, :question, :description)";
        
        try
        {
            $db = new DatabaseConnection();
            $connection = $db->get_connection();
            $statement = $connection->prepare($query);
            $statement->bindParam(":uid", $this->uid);
            $statement->bindParam(":name", $this->name);
            $statement->bindParam(":question", $this->question);
            $statement->bindParam(":description", $this->description);
            $statement->execute();
            
            $statement = null;
            $connection = null;
        }
        catch (PDOException $ex)
        {
            Logger::write_log("Question", $ex->getMessage());
        }
    }
    
    public function get_question_from_database($qid)
    {
        $this->qid = $qid;
        $query = "SELECT * FROM quest WHERE qid = :qid";
        
        try
        {
            $db = new DatabaseConnection();
            $connection = $db->get_connection();
            $statement = $connection->prepare($query);
            $statement->bindParam(":qid", $qid);
            $statement->execute();
            $result = $statement->fetch();
            
            $this->question = $result['question'];
            $this->name = $result['name'];
            $this->description = $result['description'];
            $this->uid = $result['uid'];
            
            $statement = null;
            $connection = null;
        }
        catch (Exception $ex)
        {
            Logger::write_log("Question", $ex->getMessage());
        }
    }
    
    public function update_question($qid)
    {
        $query = "UPDATE quest SET question = :question, description = :description"
                . " WHERE qid = :qid";
        
        try
        {
            $db = new DatabaseConnection();
            $connection = $db->get_connection();
            $statement = $connection->prepare($query);
            $statement->bindParam(":qid", $qid);
            $statement->bindParam(":question", $this->question);
            $statement->bindParam(":description", $this->description);
            $statement->execute();
            
            $statement = null;
            $connection = null;
        }
        catch (Exception $ex)
        {
            Logger::write_log("Question", $ex->getMessage());
        }
    }
}

