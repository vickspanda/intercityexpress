<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';
include '../process/connect.php';
include '../process/!admin_username.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/pass_account.css">
    <link rel="stylesheet" href="../design/ad_options.css">
    <title>Dashboard</title>
    <script src="../script/admin_logout.js" defer></script>


</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <footer>
            <div class="col1">
                <div class="nav">
                    <ul>
                    <li><a href="ad_pass_options.php">PASSENGERS</a></li>
                        <li><a href="ad_ta_options.php">TRAVEL AGENTS</a></li>
                        <li><a href="ad_emp_options.php">EMPLOYEES</a></li>
                        <li><a href="ad_train_options.php">TRAINS</a></li>
                        <li><a href="ad_station_options.php" id="ta_selected">STATIONS</a></li>
                        <li><a href="ad_view_options.php">VIEW USERS</a></li>
                        <li><a href="ad_more_options.php" >MORE OPTIONS</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            <div class="col2_ppv">
                 <br><br><br>
                 <button onclick="location.href='ad_add_station.php'" type="button" id="signup2">ADD STATION</button>

                 <br><br>
                 <br><br>
                 <button onclick="location.href='ad_edit_station.php'" type="button" id="signup2">EDIT STATION</button><br><br><br><br>
                 <button onclick="location.href='ad_view_stations.php?status=In-active'" type="button" id="signup2">INACTIVE STATIONS</button><br><br>
                
            </div>
            <div class="col3_ppv">
                <br><br><br>
                <button onclick="location.href='ad_rem_station.php'" type="button" id="signup2">REMOVE STATION</button><br><br>
                
                <br><br>
                <button onclick="location.href='ad_act_station.php'" type="button" id="signup2">ACTIVATE STATION</button><br><br>

                <br><br>
                
                <button onclick="location.href='ad_view_stations.php?status=Active'" type="button" id="signup2">VIEW STATIONS</button>

                 
                <br> <br> 
            </div>
        </footer>
        <div class="signup">
            <br><br>
        </div>
    </div>
</body>
</html>
