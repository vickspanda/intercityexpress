<?php

include '../process/connect_check.php';

header('Content-Type: application/json'); // Set the content type to JSON

if (isset($_POST['station_name'])) {
    $station_name = $_POST['station_name'];

    try {
        $query = $conn->prepare("SELECT station_code, state, no_of_platform FROM stations WHERE station_name = :station_name");
        $query->bindParam(':station_name', $station_name);
        $query->execute();

        if ($query->rowCount() > 0) {
            $station = $query->fetch(PDO::FETCH_ASSOC);
            echo json_encode($station);
        } else {
            echo json_encode(['error' => 'Station not found']);
        }
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Station name not provided']);
}

$conn = null; // close the connection
?>
