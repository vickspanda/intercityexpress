<?php
echo "<!DOCTYPE html>
<head>
    <title>Authenticating ...</title>
</head>
<body>
</body>
</html>";

include '../process/connect.php';
$ad_conn = $conn;

// Validate username and password from form submission
$ad_username = $_POST["ad_username"] ?? '';
$ad_password = $_POST["ad_password"] ?? '';

include '../process/!admin_username.php';


// Sanitize inputs if needed (not shown here, but recommended)
$ad_username = pg_escape_string($ad_conn, $ad_username);
$ad_password = pg_escape_string($ad_conn, $ad_password);

// Query to validate the username
$validate_username = "SELECT username, password FROM admin WHERE username='$ad_username'";
$user_query = pg_query($ad_conn, $validate_username);

if (!$user_query) {
    die("Error in SQL query: " . pg_last_error());
}

$ad_row = pg_fetch_assoc($user_query);

// Check if username exists
if (!$ad_row) {
    echo '<script>window.alert("Entered admin not found !!!"); window.location.href="index.html";</script>';
    exit;
}

// Verify the password
$hashed_password = $ad_row['password'];
if (password_verify($ad_password, $hashed_password)) {
    session_start();
    $_SESSION["admin_username"] = $ad_row['username'];
    echo '<script>window.location.href="admin_dashboard.php";</script>';
} else {
    echo '<script>window.alert("You have entered wrong password !!!"); window.location.href="index.html";</script>';
}

// Close database connection
pg_close($ad_conn);
?>
