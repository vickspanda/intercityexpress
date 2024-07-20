<?php
// fetch_station_details.php
header('Content-Type: application/json'); // Set the content type to JSON

// Database connection details
$DB_SERVER = 'localhost'; // e.g., 'localhost'
$DB_USERNAME = 'postgres'; // e.g., 'postgres'
$DB_PASSWORD = 'Vick$1428';
$DB_DATABASE = 'intercityexpress';

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
                    $route_code = $query->fetch(PDO::FETCH_ASSOC)['route_code'];
                    $query_final = $conn->prepare("SELECT route_code FROM routes WHERE route_code = :route_code AND status = 'In-active'");
                    $query_final->bindParam(':route_code', $route_code);
                    $query_final->execute();
                    if($query_final->rowCount() > 0) {
                        $station = $query_final->fetch(PDO::FETCH_ASSOC);
                        echo json_encode($station);
                    }
                    $query_f = $conn->prepare("SELECT route_code FROM routes WHERE route_code = :route_code AND status = 'Active'");
                    $query_f->bindParam(':route_code', $route_code);
                    $query_f->execute();
                    if($query_f->rowCount() > 0) {
                        echo json_encode(['error' => 'In-active Route not found']);
                    }
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
