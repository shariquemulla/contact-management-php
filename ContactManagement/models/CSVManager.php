<?php

require("Client.php");
require("ClientManager.php");

class CSVManager {
    public $exportFilepath = "./../filesExported/";
    public $importFilepath = "./../filesImported/";
    private $clientManager;

    public function __construct() {
        $this->clientManager = new ClientManager;
    }
    
    public function import($filename) {
        $file = @fopen($this->importFilepath.$filename, "r") or die("Couldn't open file");
        
        // Create Client objects based on each row
        while (($line = fgetcsv($file)) !== FALSE) {
            if(!empty($line) && isset($line[1])) {
                //$line is an array of the csv elements
                $client = new Client;
                $client->firstName      = $line[0];
                $client->lastName       = $line[1];
                $client->emailAddress   = $line[3];
                $client->phoneNumber    = $line[2];
                $client->birthday       = $line[8];
                $client->streetAddress  = $line[4];
                $client->city           = $line[5];
                $client->province       = $line[6];
                $client->postalCode     = $line[7];

                $this->clientManager->saveClient($client);
            }
        }
        fclose($file);
    }

    public function export($filename) {
        $allClients = $this->clientManager->getAllClients();

        // Export all data into CSV
        $file = @fopen($this->exportFilepath.$filename, "w") or die("Couldn't create file."); // note die() & @ for error suppression            
        foreach ($allClients as $key => $client) {
            $data = array(  
                            $client->firstName, 
                            $client->lastName, 
                            $client->phoneNumber, 
                            $client->emailAddress, 
                            $client->streetAddress, 
                            $client->city, 
                            $client->province, 
                            $client->postalCode, 
                            $client->birthday 
                        );
            fputcsv($file, $data);
        }
        fclose($file);

        // Return file to the browser
        $attachment_location = $this->exportFilepath.$filename;
        if (file_exists($attachment_location)) {

            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Cache-Control: public");                // needed for internet explorer
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length:".filesize($attachment_location));
            header("Content-Disposition: attachment; filename=clientInfo.csv");
            readfile($attachment_location);
            die();        
        } else {
            die("Error: File not found.");
        } 
    }
    
}
