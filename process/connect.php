<?php

$servername = 'localhost';
$dbuser = 'your_user';
$dbpass = 'your_password';
$db = 'intercityexpress';

// Create connection
$conn = pg_connect("host=$servername dbname=$db user=$dbuser password=$dbpass");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

?>