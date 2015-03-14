<?php
/**
 * This class handles all the operations related to
 * posts created on the application.
 *
 * @author pratyush
 */

include "autoload.php";

class Post
{
    private $pid;           //  Post Id
    private $uid;           //  User Id
    private $title;         //  Title of the post
    private $post_path;     //  Path of the post
    private $post_content;  //  Content of the post
    private $likes;         //  Likes on the post
    private $state;         //  State of the post
    private $base_path;
    
    function __construct()
    {
        $this->pid = 0;
        $this->uid = 0;
        $this->title = "";
        $this->post_path = "";
        $this->post_content = "";
        $this->likes = 0;
        $this->state = "draft";
        $this->base_path = "./data";
    }
    
    /**
     * Function to set the uid for the post.
     * @param int $uid
     */
    public function set_uid($uid)
    {
        $this->uid = $uid;
    }
    
    /**
     * Function to set the title of the post
     * @param string $title
     */
    public function set_title($title)
    {
        $this->title = $title;
    }
    
    /**
     * Function to set the content of the post
     * @param string $content
     */
    public function set_post_content($content)
    {
        $this->post_content = $content;
    }
    
    /**
     * Function to get pid of the post
     * @return int
     */
    public function get_pid()
    {
        return $this->pid;
    }
    
    /**
     * Function to get uid of the post
     * @return int
     */
    public function get_uid()
    {
        return $this->uid;
    }
    
    /**
     * Function to get title of the post
     * @return string
     */
    public function get_title()
    {
        return $this->title;
    }
    
    /**
     * Function to get path of the post
     * @return string
     */
    public function get_post_path()
    {
        return $this->post_path;
    }
    
    /**
     * Function to get content of the post
     * @return string
     */
    public function get_post_content()
    {
        return $this->post_content;
    }
    
    /**
     * FUnction to get likes on the post
     * @return int
     */
    public function get_likes()
    {
        return $this->likes;
    }
    
    /**
     * Function to get the state of the post.
     * @return string
     */
    public function get_state()
    {
        return $this->state;
    }
    
    /**
     * Function to create user directory if not exist already.
     * If directory is created then its path will be stored in
     * base path property.
     * @param type $username
     */
    private function create_user_directory($username)
    {
        $user = new User();
        $user->set_details_from_database($username);
        $this->uid = $user->get_id();
        $this->base_path = $this->base_path."/".$this->uid;
        
        if (!file_exists($this->base_path))
        {
            mkdir($this->base_path, 0777, true);
        }
    }
    
    /**
     * Function to create directory named as the post id.
     * @param int $id
     */
    private function create_post_directory($id)
    {
        $this->post_path = $this->base_path."/".$id;
        if (!file_exists($this->post_path))
        {
            mkdir($this->post_path, 0777, true);
        }
    }
    
    /**
     * Function to create a new post.
     * @param string $username
     */
    public function create_new_post($username)
    {
        $this->create_user_directory($username);
        $query = "INSERT INTO post(uid, likes, title, state) VALUES(:uid, :likes, :title, :state)";
        
        try
        {
            $db = new DatabaseConnection();
            $connection = $db->get_connection();
            $statement = $connection->prepare($query);
            $statement->bindParam(":uid", $this->uid);
            $statement->bindParam(":likes", $this->likes);
            $statement->bindParam(":state", $this->state);
            $statement->bindParam(":title", $this->title);
            $statement->execute();
            
            $this->pid = $connection->lastInsertId();
            $this->create_post_directory($this->pid);
            $query = "UPDATE post SET post = :path WHERE pid = :pid";
            $statement = $connection->prepare($query);
            $statement->bindParam(":path", $this->post_path);
            $statement->bindParam(":pid", $this->pid);
            $statement->execute();
            
            $statement = null;
            $connection = null;
            
        }
        catch (Exception $ex)
        {
            Logger::write_log("Post", $ex->getMessage());
        }
    }
    
    /**
     * Function to set the post properties using the pid and
     * uid given in the arguments.
     * @param type $pid
     * @param type $uid
     */
    public function get_post($pid, $uid)
    {
        $this->pid = $pid;
        $this->uid = $uid;
        
        try
        {
            $db = new DatabaseConnection();
            $connection = $db->get_connection();
            $query = "SELECT title, post, likes, state FROM post WHERE pid = :pid";
            $statement = $connection->prepare($query);
            $statement->bindParam(":pid", $this->pid);
            $statement->execute();
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            $result = $statement->fetch();
            
           if ($result)
           {
                $this->post_path = $result["post"];
                $this->title = $result["title"];
                $this->likes = $result["likes"];
                $this->state = $result["state"];
           }
            $statement = null;
            $connection = null;
            
            $path = $this->post_path."/post.md";
            $file = fopen($path, "r");
            $this->post_content = fread($file, filesize($path));
            fclose($file);
        }
        catch (PDOException $ex)
        {
            Logger::write_log("Post", $ex->getMessage());
        }
    }
}
