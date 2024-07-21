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
$book = FALSE;

$pass_username = $_POST["pass_username"] ?? '';
$pass_password = $_POST["pass_password"] ?? '';
if(isset($_SESSION['book']) == TRUE){
    $book = $_SESSION["book"];
    $pass_username = $_SESSION["pass_username"] ?? '';
    $pass_password = $_SESSION["pass_password"] ?? '';
    if (!$pass_username || !$pass_password) {
        echo '<script>window.location.href="../index.html";</script>';
        exit();
    }
}
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
        if($book == FALSE){
            $_SESSION['pass_username'] = $pass_username;
        }else{
            $_SESSION['username'] = $pass_username;
            $_SESSION['pass_username'] = NULL;
            $_SESSION["pass_password"] = NULL;

        }
        $status_db = $row['status'];
        if($status_db === 'Active') {
            if($book == FALSE){
                echo '<script>window.location.href="passenger_dashboard.php";</script>';
            }else{
                echo '<script>window.location.href="../process/add_details.php";</script>';
            }
        }else{
            if($book == FALSE){
                $_SESSION["userType"] = 'passenger';
                echo '<script>window.location.href="../process/block_alert.php";</script>';
            }else{
                session_destroy();
                session_abort();
                echo '<script>window.alert("You are not allowed to Book Tickets as Your Services are suspended by the Authority !!");window.location.href="../index.html";</script>';
            }
        }
    } else {
        if($book == FALSE){
            echo '<script>window.alert("You have entered wrong password!!!"); window.location.href="index.html";</script>';
            
        }else{
            echo '<script>window.alert("You have entered wrong password!!!"); window.location.href="../process/book_login.php";</script>';
        }
    }
} else {
    if($book == FALSE){
        echo '<script>window.alert("Entered username not found !!!"); window.location.href="index.html";</script>';
                
    }else{
        echo '<script>window.alert("Entered username not found !!!"); window.location.href="../process/book_login.php";</script>';
    }
}


pg_close($conn);
?>
