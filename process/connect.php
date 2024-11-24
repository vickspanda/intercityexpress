<?php

$servername = getenv('DB_HOST');
$dbuser = getenv('DB_USER');
$dbpass = getenv('DB_PASS');
$db = getenv('DB_NAME');

// Create connection
$conn = pg_connect("host=$servername dbname=$db user=$dbuser password=$dbpass");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

?>
