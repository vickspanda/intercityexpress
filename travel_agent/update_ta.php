<?php
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Updating...</title>
</head>
<body>
</body>
</html>";

include '../process/connect.php';


// Start session
session_start();

$ta_username = $_SESSION["reset_ta_username"];
$ta_password = $_POST["ta_password"];

// Check if the username is set in session
if (!$ta_username) {
    echo '<script>window.location.href="forgot_ta.html"</script>';
    exit();
}

// Hash the password using password_hash
$ta_hashed_password = password_hash($ta_password, PASSWORD_DEFAULT);

// Update the password in the database
$update_ta_pass = "UPDATE travel_agent SET password='$ta_hashed_password' WHERE username='$ta_username';";
$ta_query = pg_query($conn, $update_ta_pass);

// Destroy the session
session_destroy();

// Check if the query was successful
if ($ta_query) {
    echo '<script>window.alert("Password changed successfully!"); window.location.href="index.html"</script>';
} else {
    echo '<script>window.alert("Got some technical issue!"); window.location.href="index.html"</script>';
}

// Close the connection
pg_close($conn);
?>
