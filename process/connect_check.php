<?php

$DB_SERVER = 'db'; // e.g., 'localhost'
$DB_USERNAME = 'vickspanda_user'; // e.g., 'postgres'
$DB_PASSWORD = 'f9bkm3PUogNzIS2MSQi5qW35j093X9IW';
$DB_DATABASE = 'vickspanda';

try {
    $conn = new PDO("pgsql:host=$DB_SERVER;dbname=$DB_DATABASE", $DB_USERNAME, $DB_PASSWORD);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => "Connection failed: " . $e->getMessage()]);
    exit();
}

?>
