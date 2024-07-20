<?php
// Assuming you have already established a PostgreSQL connection
include '../process/connect_check.php';
$pdo = $conn;

// Function to check if the username exists
function isUsernameTaken($pdo, $username) {
    $query = "SELECT COUNT(*) FROM passenger WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['username' => $username]);
    $count = $stmt->fetchColumn();
    return $count > 0;
}

// Check if username is provided in the POST request
if (isset($_POST['p_username'])) {
    $username = $_POST['p_username'];

    // Check if the username is taken
    if (isUsernameTaken($pdo, $username)) {
        echo "Username is already taken";
    }
}
?>
