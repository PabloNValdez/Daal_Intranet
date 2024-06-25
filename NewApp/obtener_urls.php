<?php

ini_set('error_reporting', E_ALL);

function getUrlsFromDatabase($host, $user, $pass, $dbname) {
    $mysqli = new mysqli($host, $user, $pass, $dbname);

    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    $result = $mysqli->query("SELECT url FROM temp_urls");

    if (!$result) {
        die("Error en la consulta: " . $mysqli->error);
    }

    $urls = array();
    while ($row = $result->fetch_assoc()) {
        $urls[] = $row['url'];
    }

    $mysqli->close();

    return $urls;
}

$host = "localhost";
$user = "Getsingular";
$pass = "XdKFu67LyjtFQQvM";
$dbname = "conversor";
$savedir = 'temp_downloads';
$zipfile = 'downloads.zip';

$urls = getUrlsFromDatabase($host, $user, $pass, $dbname);

header('Content-Type: application/json');
echo json_encode($urls);

?>
