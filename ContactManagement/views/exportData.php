<?php

// Check Authentication
session_start();
if(!isset($_SESSION['auth']) || $_SESSION['auth'] == "false") {
    header("Location: login.php");
    exit();
}

require_once("./../models/CSVManager.php");

$csvManager = new CSVManager();
$file = $csvManager->export(time().".csv");



