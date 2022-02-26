<?php

require_once('User.php');

class Client extends User {
    public $birthday;
    public $phoneNumber;
    public $streetAddress;
    public $city;
    public $province;
    public $postalCode;

    public function __construct() {}
}
