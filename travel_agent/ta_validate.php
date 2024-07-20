<?php
echo "<!DOCTYPE html>
<head>
    <title>Authenticating ...</title>
</head>
<body>
</body>
</html>";

include '../process/connect.php';

// Establish connection
$ta_conn = $conn;

// Validate username and password from form submission
$ta_username = $_POST["ta_username"] ?? '';
$ta_password = $_POST["ta_password"] ?? '';
include '../process/!ta_username.php';

if (!$ta_username || !$ta_password) {
    echo '<script>window.location.href="index.html";</script>';
    exit;
}

// Sanitize inputs if needed (not shown here, but recommended)
$ta_username = pg_escape_string($ta_conn, $ta_username);
$ta_password = pg_escape_string($ta_conn, $ta_password);

// Query to validate the username
$validate_username = "SELECT username, password, status FROM travel_agent WHERE username='$ta_username'";
$user_query = pg_query($ta_conn, $validate_username);

if (!$user_query) {
    die("Error in SQL query: " . pg_last_error());
}

$ta_row = pg_fetch_assoc($user_query);

// Check if username exists
if (!$ta_row) {
    echo '<script>window.alert("Entered username not found !!!"); window.location.href="index.html";</script>';
    exit;
}

// Verify the password
$hashed_password = $ta_row['password'];
if (password_verify($ta_password, $hashed_password)) {
    $status_db = $ta_row['status'];
    session_start();
    $_SESSION["ta_username"] = $ta_username;
    if ($status_db === 'Not-verified') {
        echo '<script>window.location.href="ta_alert.php";</script>';
    } else if($status_db === 'Active'){
        echo '<script>window.location.href="ta_dashboard.php";</script>';
    }
    else {
        $_SESSION["userType"] = 'travel_agent';
            echo '<script>window.location.href="../process/block_alert.php";</script>';
    }
} else {
    echo '<script>window.alert("You have entered wrong password !!!"); window.location.href="index.html";</script>';
}

// Close database connection
pg_close($ta_conn);
?>
