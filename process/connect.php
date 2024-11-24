<?php

$servername = 'DB_HOST';
$dbuser = 'DB_USER';
$dbpass = 'DB_PASS';
$db = 'DB_NAME';

// Create connection
$conn = pg_connect("host=$servername dbname=$db user=$dbuser password=$dbpass");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

?>
