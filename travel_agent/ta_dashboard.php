<?php
session_start();
$ta_username = $_SESSION["ta_username"] ?? '';

include '../process/!ta_username.php';

include '../process/connect.php';
$username = $ta_username;
$userType = 'travel_agent';
$_SESSION['userType'] = $userType;
include '../process/getUserStatus.php';

$get_ta_name_query = "SELECT ta_name FROM travel_agent WHERE username = $1";
$ta_name_result = pg_query_params($conn, $get_ta_name_query, array($ta_username));

if ($ta_name_result && pg_num_rows($ta_name_result) > 0) {
    $ta_name_row = pg_fetch_row($ta_name_result);
    $ta_name = $ta_name_row[0];
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
    <link rel="stylesheet" href="../design/ta_account.css">
    <title>Dashboard</title>
    <script src="../script/ta_logout.js" defer></script>

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
                        <li><a href="../process/change_pass.php">CHANGE PASSWORD</a></li>
                        <li><a href="../travel_agent/ta_view_profile.php">YOUR PROFILE</a></li>
                        <li><a href="../travel_agent/ta_view_more.php">CONTACT DETAILS</a></li>
                        <li><a href="#">FEEDBACK</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            <div class="col2">
                <div class="welcome">
                    Welcome <?php echo htmlspecialchars($ta_name); ?>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
