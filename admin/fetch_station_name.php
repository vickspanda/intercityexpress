<?php
include '../process/connect_check.php';

header('Content-Type: application/json'); // Set the content type to JSON

if (isset($_POST['station_code'])) {
    $station_code = $_POST['station_code'];

    try {
        $query = $conn->prepare("SELECT station_name FROM stations WHERE station_code = :station_code");
        $query->bindParam(':station_code', $station_code);
        $query->execute();

        if ($query->rowCount() > 0) {
            $name = $query->fetch(PDO::FETCH_ASSOC);
            echo json_encode($name);
        } else {
            echo json_encode(['error' => 'Train not found']);
        }
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Train No not provided']);
}

$conn = null; // close the connection
?>
