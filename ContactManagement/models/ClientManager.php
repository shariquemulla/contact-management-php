<?php

require_once("Client.php");

class ClientManager {
    private $tableName;
    private $connection;
    private $config;

    public function __construct() {
        $this->config = parse_ini_file('./../config.ini');

        //set up table name
        $this->tableName = "client";

        //connect to MySQL and select database to use
        $this->connection = mysqli_connect($this->config['servername'], $this->config['username'], $this->config['password']) 
                or die(mysqli_error($this->connection));

        // mysqli_report(MYSQLI_REPORT_ALL);

    }
    
    public function getAllClients() {

        $db = @mysqli_select_db($this->connection, $this->config['dbname']) or die(mysqli_error($this->connection));

        $sql = "SELECT * FROM $this->tableName ORDER BY id";
        $result = @mysqli_query($this->connection, $sql) or die(mysqli_error($this->connection));

        $allClients = array();

        while ($row = mysqli_fetch_array($result)) {
            $client = new Client;
            $client->id             = $row['id'];
            $client->firstName      = $row['firstName'];
            $client->lastName       = $row['lastName'];
            $client->emailAddress   = $row['emailAddress'];
            $client->phoneNumber    = $row['phoneNumber'];
            $client->birthday       = $row['birthday'];
            $client->streetAddress  = $row['streetAddress'];
            $client->city           = $row['city'];
            $client->province       = $row['province'];
            $client->postalCode     = $row['postalCode'];

            array_push($allClients, $client);
        }
        return $allClients;
    }

    public function getClientById($id) {

        $db = @mysqli_select_db($this->connection, $this->config['dbname']) or die(mysqli_error($this->connection));

        $statement = $this->connection->prepare("SELECT * FROM $this->tableName WHERE id = ? LIMIT 1");
        $statement->bind_param('i', $id);
        $statement->execute();

        $result = $statement->get_result();

        if($result->num_rows != 1) {
            return false;
        } else {
            $result->data_seek(0);
            $row = $result->fetch_assoc();

            $client = new Client;
            $client->id             = $row['id'];
            $client->firstName      = $row['firstName'];
            $client->lastName       = $row['lastName'];
            $client->emailAddress   = $row['emailAddress'];
            $client->phoneNumber    = $row['phoneNumber'];
            $client->birthday       = $row['birthday'];
            $client->streetAddress  = $row['streetAddress'];
            $client->city           = $row['city'];
            $client->province       = $row['province'];
            $client->postalCode     = $row['postalCode'];            
        }
        return $client;
    }

    public function getClientsByBirthMonth($month) {
        $db = @mysqli_select_db($this->connection, $this->config['dbname']) or die(mysqli_error($this->connection));

        $sql = "SELECT * FROM $this->tableName WHERE birthday like '%-$month-%' ORDER BY id";
        $result = @mysqli_query($this->connection, $sql) or die(mysqli_error($this->connection));

        $allClients = array();

        while ($row = mysqli_fetch_array($result)) {
            $client = new Client;
            $client->id             = $row['id'];
            $client->firstName      = $row['firstName'];
            $client->lastName       = $row['lastName'];
            $client->emailAddress   = $row['emailAddress'];
            $client->phoneNumber    = $row['phoneNumber'];
            $client->birthday       = $row['birthday'];
            $client->streetAddress  = $row['streetAddress'];
            $client->city           = $row['city'];
            $client->province       = $row['province'];
            $client->postalCode     = $row['postalCode'];

            array_push($allClients, $client);
        }
        return $allClients;
    }

    public function getAllClientsEmail() {

        $db = @mysqli_select_db($this->connection, $this->config['dbname']) or die(mysqli_error($this->connection));

        $sql = "SELECT emailAddress FROM $this->tableName ORDER BY id";
        $result = @mysqli_query($this->connection, $sql) or die(mysqli_error($this->connection));

        $emailArray = array();

        while ($row = mysqli_fetch_array($result)) {
            array_push($emailArray, $row['emailAddress']);
        }

        return $emailArray;
    }

    public function saveClient($client) {

        $db = @mysqli_select_db($this->connection, $this->config['dbname']) or die(mysqli_error($this->connection));
        $statement = $this->connection->prepare("INSERT INTO $this->tableName (firstName, lastName, emailAddress, phoneNumber, birthday, streetAddress, city, province, postalCode) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $statement->bind_param('sssssssss', $client->firstName, $client->lastName, $client->emailAddress, $client->phoneNumber, $client->birthday, $client->streetAddress, $client->city, $client->province, $client->postalCode);

        $statement->execute();
        return True;
        
    }

    public function updateClient($client, $id) {

        $db = @mysqli_select_db($this->connection, $this->config['dbname']) or die(mysqli_error($this->connection));
        $statement = $this->connection->prepare("UPDATE $this->tableName SET firstName = ?, lastName = ?, emailAddress = ?, phoneNumber = ?, birthday = ?, streetAddress = ?, city = ?, province = ?, postalCode = ? WHERE id = ?");

        $statement->bind_param('sssssssssi', $client->firstName, $client->lastName, $client->emailAddress, $client->phoneNumber, $client->birthday, $client->streetAddress, $client->city, $client->province, $client->postalCode, $id);

        $statement->execute();
        return True;
    }

    public function deleteClient($id) {
        $db = @mysqli_select_db($this->connection, $this->config['dbname']) or die(mysqli_error($this->connection));
        $statement = $this->connection->prepare("DELETE FROM $this->tableName WHERE id = ?");

        $statement->bind_param('i', $id);

        $statement->execute();
        return True;
    }
    
}
