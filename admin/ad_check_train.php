<?php

session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

include '../process/connect_check.php';
$pdo = $conn;

// Function to check if the train number exists
function isTrainNoTaken($pdo, $train_no) {
    $query = "SELECT COUNT(*) FROM trains WHERE train_no = :train_no";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['train_no' => $train_no]);
    $count = $stmt->fetchColumn();
    return $count > 0;
}

// Check if train number is provided in the POST request
if (isset($_POST['train_no'])) {
    $train_no = $_POST['train_no'];
    if (isTrainNoTaken($pdo, $train_no)) {
        echo 'Train Number Already Exists';
    }  
}

if (isset($_POST['train'])) {
    $train_no = $_POST['train'];
    if (!isTrainNoTaken($pdo, $train_no)) {
        echo 'Train Not Found !!!';
    }  
}

?>
