<?php

$servername = 'db';
$dbuser = 'vickspanda_user';
$dbpass = 'f9bkm3PUogNzIS2MSQi5qW35j093X9IW';
$db = 'vickspanda';

// Create connection
$conn = pg_connect("host=$servername dbname=$db user=$dbuser password=$dbpass");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

?>
