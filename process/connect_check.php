<?php

$DB_SERVER = 'DB_HOST'; // e.g., 'localhost'
$DB_USERNAME = 'DB_USER'; // e.g., 'postgres'
$DB_PASSWORD = 'DB_PASS';
$DB_DATABASE = 'DB_NAME';

try {
    $conn = new PDO("pgsql:host=$DB_SERVER;dbname=$DB_DATABASE", $DB_USERNAME, $DB_PASSWORD);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => "Connection failed: " . $e->getMessage()]);
    exit();
}

?>
