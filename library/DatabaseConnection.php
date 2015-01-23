<?php

    /**
     * This class provide a function which
     * return a connection to the database server.
     */
     class DatabaseConnection
     {
         private $servername;
         private $db_username;
         private $db_password;
         private $db_name;
         
         function __construct()
         {
             $this->get_details();
         }
         
         /**
          * This function reads the relevant information
          * from the "db.txt" file and store it into the
          * properties of this class.
          */
         private function get_details()
         {
             $file = fopen("./db.txt", "r") or die("Unable to open file");
             $this->servername = trim(fgets($file));
             $this->db_username = trim(fgets($file));
             $this->db_password = trim(fgets($file));
             $this->db_name = trim(fgets($file));
             fclose($file);
         }
         
         /**
          * This function returns a connection to
          * the database. Throws PDOException
          * @return \PDO  connection to database
          */
         public function get_connection()
         {
             $connection = new PDO("mysql:host=$this->servername;dbname=$this->db_name",
                     $this->db_username, $this->db_password);
             
             //  Set the PDO error mode to exception
             $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             
             return $connection;
         }
     }
?>