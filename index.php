<?php

include_once 'common.php';

//get guid from GET
$guid = $_GET['token'];

// selct from tokens where token = $guid
$sql = "SELECT * FROM tokens WHERE token = :guid";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':guid' => $guid));

//check if token exists
if ($stmt->rowCount() == 0) {
    // return 500 http error
    http_response_code(500);
    exit;
}

// get host, data_key and data_value from GET
$host = $_GET['host'];
$data_key = $_GET['data_key'];
$data_value = $_GET['data_value'];

// insert into monitor-data (host, data_key, data_value) values ($host, $data_key, $data_value)
$sql = "INSERT INTO `monitor-data` (host, data_key, data_value) VALUES (:host, :data_key, :data_value)";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':host' => $host, ':data_key' => $data_key, ':data_value' => $data_value));

// return 200 http success
http_response_code(200);



?>