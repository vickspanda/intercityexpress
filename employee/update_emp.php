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

$emp_username = $_SESSION["reset_emp_username"];
$emp_password = $_POST["emp_password"];

// Check if the username is set in session
if (!$emp_username) {
    echo '<script>window.location.href="forgot_emp.html"</script>';
    exit();
}

// Hash the password using password_hash
$emp_hashed_password = password_hash($emp_password, PASSWORD_DEFAULT);

// Update the password in the database
$update_emp_pass = "UPDATE employee SET password='$emp_hashed_password' WHERE username='$emp_username';";
$emp_query = pg_query($conn, $update_emp_pass);

// Destroy the session
session_destroy();

// Check if the query was successful
if ($emp_query) {
    echo '<script>window.alert("Password changed successfully!"); window.location.href="index.html"</script>';
} else {
    echo '<script>window.alert("Got some technical issue!"); window.location.href="index.html"</script>';
}

// Close the connection
pg_close($conn);
?>
