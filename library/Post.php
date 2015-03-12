<?php
/**
 * This class handles all the operations related to
 * posts created on the application.
 *
 * @author pratyush
 */
class Post
{
    private $pid;           //  Post Id
    private $uid;           //  User Id
    private $title;         //  Title of the post
    private $post_path;     //  Path of the post
    private $post_content;  //  Content of the post
    private $likes;         //  Likes on the post
    private $state;
    
    function __construct()
    {
        $this->pid = 0;
        $this->uid = 0;
        $this->title = "";
        $this->post_path = "";
        $this->post_content = "";
        $this->liked = 0;
        $this->state = "draft";
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
}
