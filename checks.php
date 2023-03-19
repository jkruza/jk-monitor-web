<?php

include_once 'common.php';


do_http_check("netia-tcz-01.geeksync.org","");




function do_http_check($host, $path)
{
    global $pdo;

    // do http requets to https://tcz01.geeksync.org/ and return status code 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://$host/$path");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language: en-us,en;q=0.5"));
    curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);


    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    

    // insert into monitor-data (host, data_key, data_value) values ()
    $sql = "INSERT INTO `monitor-data` (host, data_key, data_value) VALUES (:host, :data_key, :data_value)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':host' => $host, ':data_key' => "http_status", ':data_value' => $httpcode));

}
?>