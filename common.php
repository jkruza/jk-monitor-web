<?php

$dbhost="localhost";
$dbuser="username";
$dbpass="password";
$dbname="database";


// include config.php if exists
if (file_exists('config.php')) {
    include 'config.php';
}

// Connect to mysql database using PDO
$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

?>