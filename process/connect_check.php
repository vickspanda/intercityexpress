<?php

$DB_SERVER = 'localhost'; // e.g., 'localhost'
$DB_USERNAME = 'postgres'; // e.g., 'postgres'
$DB_PASSWORD = 'Vick$1428';
$DB_DATABASE = 'intercityexpress';

try {
    $conn = new PDO("pgsql:host=$DB_SERVER;dbname=$DB_DATABASE", $DB_USERNAME, $DB_PASSWORD);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => "Connection failed: " . $e->getMessage()]);
    exit();
}

?>