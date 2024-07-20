<?php
session_start();
$ad_username = $_SESSION["admin_username"];
include '../process/!admin_username.php';


include '../process/connect.php';


$get_admin_name = "SELECT name FROM admin WHERE username=$1";
$admin_name_query = pg_query_params($conn, $get_admin_name, array($ad_username));
$admin_name_result = pg_fetch_row($admin_name_query);

if (!$admin_name_result) {
    die("Query failed: " . pg_last_error());
}

pg_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/admin_account.css">
    <title>Dashboard</title>
    <script src="../script/admin_logout.js" defer></script>

</head>
<body>
    <div class="bg_admin_account"></div>
    <div class="admin_account">
        <footer>
            <div class="col1">
                <div class="nav">
                    <ul>
                    <li><a href="ad_pass_options.php">PASSENGERS</a></li>
                        <li><a href="ad_ta_options.php">TRAVEL AGENTS</a></li>
                        <li><a href="ad_emp_options.php">EMPLOYEES</a></li>
                        <li><a href="ad_train_options.php">TRAINS</a></li>
                        <li><a href="ad_station_options.php">STATIONS</a></li>
                        <li><a href="ad_view_options.php">VIEW USERS</a></li>
                        <li><a href="ad_more_options.php" >MORE OPTIONS</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            <div class="col2">
                <div class="welcome">
                    Welcome <?php echo htmlspecialchars($admin_name_result[0], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
