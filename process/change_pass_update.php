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

if(isset($_SESSION["pass_username"])){
    $username = $_SESSION["pass_username"];
    $userType = 'passenger';
    $user = '../passenger/passenger';
}
if(isset($_SESSION["emp_username"])){
    $username = $_SESSION["emp_username"];
    $userType = 'employee';
    $user = '../employee/emp';
}
if(isset($_SESSION["ta_username"])){
    $username = $_SESSION["ta_username"];
    $userType = 'travel_agent';
    $user = '../travel_agent/ta';
}


$password = $_POST["password"];

// Check if the username is set in session
if (!$username) {
    echo '<script>window.location.href="../index.html"</script>';
    exit();
}

// Hash the password using password_hash
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Update the password in the database
$update_pass = "UPDATE $userType SET password='$hashed_password' WHERE username='$username';";
$pass_query = pg_query($conn, $update_pass);

// Check if the query was successful
if ($pass_query) {
    echo '<script>window.alert("Password changed successfully!"); window.location.href="'.$user.'_dashboard.php"</script>';
} else {
    echo '<script>window.alert("Got some technical issue!"); window.location.href="'.$user.'_dashboard.php"</script>';
}

// Close the connection
pg_close($conn);
?>
