<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

ini_set('memory_limit', '512M');

include '../../constants.php';
include '../../vendor/autoload.php';
require '../mysql_login.php';

$query = "SELECT DISTINCT author FROM pates_etds.etds WHERE author IS NOT NULL;";
$results = $connection->query($query);

$results_array = [];

while ($row = $results->fetch_assoc()) {
    array_push($results_array, $row);
}

echo json_encode($results_array);