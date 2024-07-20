<?php
session_start();

echo "<!DOCTYPE html>
<html>
<head>
  <title>Authenticating ...</title>
</head>
<body>
</body>
</html>";

include '../process/connect.php';


$pass_username = $_POST["pass_username"] ?? '';
$pass_password = $_POST["pass_password"] ?? '';
include '../process/!pass_username.php';

if (!$pass_username || !$pass_password) {
    echo '<script>window.location.href="index.html";</script>';
    exit();
}

$validate_username_query = "SELECT username, password, status FROM passenger WHERE username = $1";
$result = pg_query_params($conn, $validate_username_query, array($pass_username));

if ($result && pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);
    $pass_password_db = $row['password'];

    if (password_verify($pass_password, $pass_password_db)) {
        $_SESSION['pass_username'] = $pass_username;
        $status_db = $row['status'];
        if($status_db === 'Active') {
            echo '<script>window.location.href="passenger_dashboard.php";</script>';
        }else{
            $_SESSION["userType"] = 'passenger';
            echo '<script>window.location.href="../process/block_alert.php";</script>';
        }
    } else {
        echo '<script>window.alert("You have entered wrong password!!!"); window.location.href="index.html";</script>';
    }
} else {
    echo '<script>window.alert("Entered username not found !!!"); window.location.href="index.html";</script>';
}


pg_close($conn);
?>
