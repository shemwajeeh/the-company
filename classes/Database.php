<?php

class Database {
    // Define properties for the database connection details
    private $server_name = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "the_company";
    
    // Protected connection property to be used by classes that extend Database
    protected $conn;

    // Constructor method to create a database connection automatically
    public function __construct(){
        // Establish a new connection to the MySQL database
        $this->conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);

        // Check for connection errors and display an error message if the connection fails
        if($this->conn->connect_error){
            die('Unable to connect to the database: ' . $this->conn->connect_error);
        }
    }
}
?>
