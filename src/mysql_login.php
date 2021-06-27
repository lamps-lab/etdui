<?php
// MySQL server information.
$servername = "localhost";
$sql_username = "admin";
$sql_pass = "monarchs";
$dbname = "shields_search";

// Try connecting into the Shields Search database.
$connection = new mysqli($servername, $sql_username, $sql_pass, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
