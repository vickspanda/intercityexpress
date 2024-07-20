<?php
// fetch_station_details.php
header('Content-Type: application/json'); // Set the content type to JSON

include '../process/connect_check.php';


if (isset($_POST['from_station'])) {
    $from = $_POST['from_station'];
    if (isset($_POST['to_station'])) {
        $to = $_POST['to_station'];
        try {
            // Get the station codes
            $from_query = $conn->prepare("SELECT station_code FROM stations WHERE station_name = :station_name");
            $from_query->bindParam(':station_name', $from);
            $from_query->execute();
            $from_Stn = $from_query->fetch(PDO::FETCH_ASSOC)['station_code'];

            $to_query = $conn->prepare("SELECT station_code FROM stations WHERE station_name = :station_name");
            $to_query->bindParam(':station_name', $to);
            $to_query->execute();
            $to_Stn = $to_query->fetch(PDO::FETCH_ASSOC)['station_code'];

            if ($from_Stn && $to_Stn) {
                // Get the route code
                $query = $conn->prepare("SELECT route_code FROM routes WHERE start_station = :from_Stn AND end_station = :to_Stn");
                $query->bindParam(':from_Stn', $from_Stn);
                $query->bindParam(':to_Stn', $to_Stn);
                $query->execute();

                if ($query->rowCount() > 0) {
                    $station = $query->fetch(PDO::FETCH_ASSOC);
                    echo json_encode($station);
                } else {
                    echo json_encode(['error' => 'Route not found']);
                }
            } else {
                echo json_encode(['error' => 'Station codes not found']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'End Station not provided']);
    }
} else {
    echo json_encode(['error' => 'Start Station not provided']);
}

$conn = null; // close the connection
?>
