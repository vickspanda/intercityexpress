<?php
// fetch_stations.php
include '../process/connect_check.php';

header('Content-Type: application/json'); // Set the content type to JSON

try {
    $query = $conn->prepare("SELECT station_name FROM stations");
    $query->execute();
    $stations = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($stations);
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn = null; 
?>
