<?php
session_start();
$emp_username = $_SESSION["emp_username"] ?? '';

include '../process/!emp_username.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/pass_account.css">
    <link rel="stylesheet" href="../design/ad_options.css">
    <title>Dashboard</title>
    <script src="../script/emp_logout.js"></script>


</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <footer>
            <div class="col1">
            <div class="nav">
                    <ul>
                        <li><a href="../employee/emp_view_options.php">UPCOMING TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=PAST">PAST TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=DOWNLOAD">DOWNLOAD</a></li>
                        <li><a href="../process/change_pass.php">CHANGE PASSWORD</a></li>
                        <li><a href="../employee/emp_view_profile.php">YOUR PROFILE</a></li>
                        <li><a href="../employee/emp_view_more.php">CONTACT DETAILS</a></li>
                        <li><a href="../process/feedback.php">FEEDBACK</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="col2_ppv">
                 <br><br><br><br><br>


                 <br><br>
                 <button onclick="location.href='../process/get_task.php?title=UPCOMING'" type="button" id="signup2">VIEW TRIPS</button><br><br>
                 <br><br>
                
            </div>
            <div class="col3_ppv">
                 <br><br>
                 <br><br><br><br><br>
                <button onclick="location.href='../process/get_task.php?title=CANCEL'" type="button" id="signup2">CANCEL TRIPS</button><br><br>
                
                <br><br>
                <br><br>
                <br> <br> 
            </div>
        </footer>
        <div class="signup">
            <br><br>
        </div>
    </div>
</body>
</html>
