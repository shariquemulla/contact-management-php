<?php

class UserAuth {

    private $connection = null;
    private $table_name = "user";
    

    public function __construct() {
        $config = parse_ini_file('./../config.ini');

        //set up database and table names
        $db_name = $config['dbname'];

        //connect to MySQL and select database to use
        $this->connection = mysqli_connect($config['servername'], $config['username'], $config['password']) 
                or die(mysqli_error($connection));
        $db = mysqli_select_db($this->connection, $db_name) or die(mysqli_error($this->connection));
        // mysqli_report(MYSQLI_REPORT_ALL);
    }

    public function login($email, $password) {

        $statement = $this->connection->prepare("SELECT * FROM $this->table_name WHERE emailAddress = ? LIMIT 1");

        $statement->bind_param('s', $email);

        $statement->execute();

        $result = $statement->get_result();

        if($result->num_rows != 1) {
            $access = false;
        } else {
            $result->data_seek(0);
            $hashedPassword = $result->fetch_assoc()['password'];

            if(password_verify($password, $hashedPassword)) {
                $access = true;    
            } else {
                $access = false;
            }
        }

        // print_r($_SESSION);
        // echo session_status();
        return $access;
    }

    private function getHashed($password, $salt) {
        
    }

}