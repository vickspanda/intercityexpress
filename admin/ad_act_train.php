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
    <title>Activate Train</title>
    <link rel="stylesheet" href="../design/un-block_user.css">
    <link rel="stylesheet" href="../design/home.css">
    <script src="../script/train.js" defer></script>
</head>
<body>
    <div class="background"></div>
    <div class="login_form">
        <form id="signUpForm" action="add_rem_trains.php" method="post" onsubmit="validateForm(event)">
            <div class="lbl1">
                <br><br><br>
                <label>Activate Train !!!</label>
            </div>
            <div class="credentials">
            <br><br>
                <input type="text" id="train" name="train" placeholder="Enter Train Number" onblur="validateTrain()" autofocus required>
                <br><br> <div id="trainMessage"></div>
                <input type="text" name="do" id="do" value="ACT" hidden><br><br>
            </div>
            <div class="submit1">
                <input type="submit" value="Activate">
                <button onclick="location.href = 'ad_train_options.php'" type="button">Cancel</button><br><br><br><br>
            </div>
        </form>
    </div>
</body>
</html>
