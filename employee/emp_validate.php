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
$emp_conn = $conn;

// Validate username and password from form submission
$emp_username = $_POST["emp_username"] ?? '';
$emp_password = $_POST["emp_password"] ?? '';
include '../process/!emp_username';
if (!$emp_username || !$emp_password) {
    echo '<script>window.location.href="index.html";</script>';
    exit;
}

// Sanitize inputs if needed (not shown here, but recommended)
$emp_username = pg_escape_string($emp_conn, $emp_username);
$emp_password = pg_escape_string($emp_conn, $emp_password);

// Query to validate the username
$validate_username = "SELECT username, password, status FROM employee WHERE username='$emp_username'";
$user_query = pg_query($emp_conn, $validate_username);

if (!$user_query) {
    die("Error in SQL query: " . pg_last_error());
}

$emp_row = pg_fetch_assoc($user_query);

// Check if username exists
if (!$emp_row) {
    echo '<script>window.alert("Entered Employee not found !!!"); window.location.href="index.html";</script>';
    exit;
}

// Verify the password
$hashed_password = $emp_row['password'];
if (password_verify($emp_password, $hashed_password)) {
    session_start();
    $_SESSION["emp_username"] = $emp_row['username'];
    $status_db = $emp_row['status'];
        if($status_db === 'Active') {
            echo '<script>window.location.href="emp_dashboard.php";</script>';
        }else{
            $_SESSION["userType"] = 'employee';
            echo '<script>window.location.href="../process/block_alert.php";</script>';
        }
} else {
    echo '<script>window.alert("You have entered wrong password !!!"); window.location.href="index.html";</script>';
}

// Close database connection
pg_close($emp_conn);
?>
