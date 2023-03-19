<?php
include_once 'common.php';

$max_data_age = 60 * 60 * 24 * 7; // 7 days
$max_data_count = 1000; // 1000 records per host

// remove all records older than $max_data_age from monitor-data table
$sql = "DELETE FROM `monitor-data` WHERE `timestamp` < :max_data_age";  
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':max_data_age' => time() - $max_data_age));

// get list of hosts from monitor-data table
$sql = "SELECT DISTINCT host FROM `monitor-data`";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$hosts = $stmt->fetchAll(PDO::FETCH_COLUMN);

foreach ($hosts as $host)
{
    // keep only last 1000 records for each host
    $sql = "DELETE FROM `monitor-data` WHERE `host` = :host AND `timestamp` < (SELECT `timestamp` FROM (SELECT `timestamp` FROM `monitor-data` WHERE `host` = :host ORDER BY `timestamp` DESC LIMIT $max_data_count, 1) AS `t`)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':host' => $host));

}




?>