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

$pass_username = $_SESSION["reset_username"];
$pass_password = $_POST["pass_password"];

// Check if the username is set in session
if (!$pass_username) {
    echo '<script>window.location.href="forgot_pass.html"</script>';
    exit();
}

// Hash the password using password_hash
$pass_hashed_password = password_hash($pass_password, PASSWORD_DEFAULT);

// Update the password in the database
$update_pass_pass = "UPDATE passenger SET password='$pass_hashed_password' WHERE username='$pass_username';";
$pass_query = pg_query($conn, $update_pass_pass);

// Destroy the session
session_destroy();

// Check if the query was successful
if ($pass_query) {
    echo '<script>window.alert("Password changed successfully!"); window.location.href="index.html"</script>';
} else {
    echo '<script>window.alert("Got some technical issue!"); window.location.href="index.html"</script>';
}

// Close the connection
pg_close($conn);
?>
