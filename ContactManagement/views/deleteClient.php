<?php

// Check Authentication
session_start();
if(!isset($_SESSION['auth']) || $_SESSION['auth'] == "false") {
    header("Location: login.php");
    exit();
}

require_once("./../models/ClientManager.php");
require_once("./../models/Client.php");

$clientManager = new ClientManager();
if(isset($_POST['deleteId'])) {

    $clientManager->deleteClient($_POST['deleteId']);
    header("Location: clientListing.php");
    exit();
} 
