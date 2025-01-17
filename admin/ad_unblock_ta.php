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
    <title>Unblock Travel Agent</title>
    <link rel="stylesheet" href="../design/un-block_user.css">
    <link rel="stylesheet" href="../design/home.css">
    <script src="../script/un-block.js" defer></script>

</head>
<body>
    <div class="background"></div>
    <div class="login_form">
        <form id="signUpForm" action="un-block_user.php" method="post" onsubmit="validateForm(event)">
            <div class="lbl1">
                <br><br><br>
                <label>Unblock Agent !!!</label>
            </div>
            <div class="credentials">
            <br><br>
                <input type="text" id="username" name="username" placeholder="Enter Agent's Username" onblur="validateUsername()" autofocus required>
                <br><br> <div id="usernameMessage"></div>
                <input type="text" id="userType" name="userType" value="travel_agent" hidden><input type="text" name="do" value="Unblock" hidden><br><br>
            </div>
            <div class="submit1">
                <input type="submit" value="Unblock">
                <button onclick="location.href = 'ad_ta_options.php'" type="button">Cancel</button><br><br><br><br>
            </div>
        </form>
    </div>
</body>
</html>
