<?php
// fetch_train_details.php

// Mock database connection and query
// Replace with your actual database connection and query logic
$train_no = $_GET['train_no'];
$trainExists = false; // Assume train does not exist by default

// Database connection details
include 'connect.php';


// Prepare and execute the query
$sql = "SELECT * FROM trains WHERE train_no = $1";
$result = pg_query_params($conn, $sql, array($train_no));

if ($result && pg_num_rows($result) > 0) {
    $trainExists = true;
}

// Free result and close connection
pg_free_result($result);
pg_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['exists' => $trainExists]);
?>
