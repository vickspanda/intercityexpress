<?php
include '../process/connect_check.php';

header('Content-Type: application/json'); // Set the content type to JSON

if (isset($_POST['train_no'])) {
    $train_no = $_POST['train_no'];

    try {
        $query = $conn->prepare("SELECT start_station, end_station FROM routes WHERE route_code IN (SELECT route_code from trains where train_no = :train_no)");
        $query->bindParam(':train_no', $train_no);
        $query->execute();

        if ($query->rowCount() > 0) {
            $stations = $query->fetch(PDO::FETCH_ASSOC);
            echo json_encode($stations);
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
