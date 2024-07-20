<?php

session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

// Assuming you have already established a PostgreSQL connection
// Replace these variables with your actual database credentials
include '../process/connect_check.php';
$pdo = $conn;

// Function to check if the username exists
function isUsernameTaken($pdo, $username, $userType) {
    if($userType === 'stations'){
        $station_name = $username;
        $query = "SELECT COUNT(*) FROM $userType WHERE station_name = :station_name";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['station_name' => $station_name]);
        $count = $stmt->fetchColumn();
    }else{
        $query = "SELECT COUNT(*) FROM $userType WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['username' => $username]);
        $count = $stmt->fetchColumn();
    }
    return $count > 0;
}

// Check if username is provided in the POST request
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $userType = $_POST["userType"];
    $wtdo = $_POST['do'];

    // Check if the username is taken
    if ($userType != 'stations' && !isUsernameTaken($pdo, $username, $userType)) {
        echo "User Not Found !!!";
    }
    if($userType === 'stations' && isUsernameTaken($pdo, $username, $userType))
    {
        if($wtdo === 'ADD'){
            echo "Station Already Exists";
        }
    }
    if($userType === 'stations')
    {
        if(!isUsernameTaken($pdo, $username, $userType) )
        {
            if($wtdo === 'REM')
            {
                echo "Station Not Found";
            }
            if($wtdo === 'ACT')
            {
                echo "Station Not Found";
            }
        }
        
    }
}
?>
