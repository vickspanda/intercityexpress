<?php
include '../process/connect_check.php';

header('Content-Type: application/json'); // Set the content type to JSON

try {
    $query = $conn->prepare("SELECT MAX(booking_limit) AS max_limit FROM limits");
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        echo json_encode(['booking_limit' => $result['max_limit']]);
    } else {
        echo json_encode(['error' => 'No booking limit found']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn = null;
?>
