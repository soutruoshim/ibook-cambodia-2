<?php
// show error reporting
error_reporting(E_ALL);
 
// start php session
session_start();
 
// set your default time-zone
date_default_timezone_set('Asia/Manila');
 
// home page url
$home_url="http://localhost/ibook-cambodia-2/";
 
// variables used for jwt
$key = "ibook-cambodia-api-key";
$issued_at = time();
$expiration_time = $issued_at + (60 * 60); // valid for 1 hour
$issuer = "http://localhost/ibook-cambodia-2/";
?>