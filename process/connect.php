<?php

$servername = 'localhost';
$dbuser = 'postgres';
$dbpass = 'Vick$1428';
$db = 'intercity';

// Create connection
$conn = pg_connect("host=$servername dbname=$db user=$dbuser password=$dbpass");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

?>