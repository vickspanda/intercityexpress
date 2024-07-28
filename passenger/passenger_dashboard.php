<?php
session_start();
$pass_username = $_SESSION["pass_username"] ?? '';

include '../process/!pass_username.php';

include '../process/connect.php';
$username = $pass_username;
$userType = 'passenger';
include '../process/getUserStatus.php';



$get_pass_name_query = "SELECT name FROM passenger WHERE username = $1";
$pass_name_result = pg_query_params($conn, $get_pass_name_query, array($pass_username));

if ($pass_name_result && pg_num_rows($pass_name_result) > 0) {
    $pass_name_row = pg_fetch_row($pass_name_result);
    $pass_name = $pass_name_row[0];
} else {
    echo '<script>window.alert("Error retrieving user information."); window.location.href="index.html";</script>';
    exit();
}

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/pa_acc.css">
    <title>Dashboard</title>
    <script src="../script/pass_logout.js"></script>
</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account">
        <footer>
            <div class="col1">
            <div class="nav">
                    <ul>
                    <li><a href="../process/get_task.php?title=UPCOMING">UPCOMING TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=PAST">PAST TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=CANCEL">CANCEL TRIP</a></li>
                        <li><a href="../process/get_task.php?title=DOWNLOAD">DOWNLOAD</a></li>
                        <li><a href="../process/change_pass.php">CHANGE PASSWORD</a></li>
                        <li><a href="../passenger/passenger_view_profile.php">YOUR PROFILE</a></li>
                        <li><a href="../process/feedback.php">FEEDBACK</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            <div class="col2">
                <div class="welcome">
                    Welcome <?php echo htmlspecialchars($pass_name); ?>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
