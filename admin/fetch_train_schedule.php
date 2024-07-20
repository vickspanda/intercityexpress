<?php
include '../process/connect_check.php';

header('Content-Type: application/json'); // Set the content type to JSON

if (isset($_POST['train_no'])) {
    $train_no = $_POST['train_no'];

    try {
        $query = $conn->prepare("SELECT * FROM train_schedule WHERE train_no = :train_no");
        $query->bindParam(':train_no', $train_no);
        $query->execute();

        if ($query->rowCount() > 0) {
            $train_schedule = $query->fetch(PDO::FETCH_ASSOC);
            echo json_encode($train_schedule);
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
