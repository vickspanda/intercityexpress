<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD ROUTE</title>
    <link rel="stylesheet" href="../design/un-block_user.css">
    <link rel="stylesheet" href="../design/home.css">
    <style>
        .error {
            color: white;
            display: none;
        }
        .invalid {
            border-color: red;
        }
    </style>
    <script src="../script/ad_add_route.js" defer></script>
</head>
<body>
    <div class="background"></div>
    <div class="login_form">
        <form id="signUpForm" action="add_rem_routes.php" method="post">
            <div class="lbl1">
                <br><br><br>
                <label>Add Route !!!</label>
            </div>
            <div class="credentials">
            <br><br>
                <div class="stations">
                <select class="from" name="from_station" required>
                    <option value="" disabled hidden selected>From</option>
                </select>
                <br><br><br>
                <select class="to" name="to_station" required>
                    <option value="" disabled hidden selected>To</option>
                </select>
                <br>
            </div><br>
            <br><input type="text" id="r_time" name="r_time" placeholder="Enter Total Time Taken (in hours)" required>
                <br>
                <span class="error" id="timeError">Please enter only in Numbers</span><br> <div id="usernameMessage"></div>
                <input type="text" id="userType" name="userType" value="stations" hidden>
                <input type="text" id="do" name="do" value="ADD" hidden><br>
            <input type="text" id="r_dist" name="r_dist" placeholder="Enter Total Distance (in kms)" required><br>
            <span class="error" id="distError">Please enter only in Numbers</span><br>
            <div class="submit0">
            <br>
                <input type="submit" value="ADD">
                <button onclick="location.href = 'ad_more_options.php'" type="button">Cancel</button><br><br><br>
            </div>
        </form>
    </div>
</body>
</html>
