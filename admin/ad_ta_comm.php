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
    <title>Set Commission</title>
    <link rel="stylesheet" href="../design/un-block_user.css">
    <link rel="stylesheet" href="../design/home.css">
    <script src="../script/un-block.js" defer></script>
</head>
<body>
    <div class="background"></div>
    <div class="login_form">
        <form id="signUpForm" action="ad_set_limit.php" method="post">
            <div class="lbl1">
                <br><br><br>
                <label>Set Commission</label>
            </div>
            <div class="credentials">
                <br><br>
                <input type="text" id="ta_comm" name="ta_comm" placeholder="Enter Commission in %" maxlength="2" pattern="\d*" required autofocus oninput="this.value=this.value.replace(/[^0-9]/g,'');">
            </div>
            <br><br>
            <div class="submit1">
                <input type="submit" value="Set">
                <button onclick="location.href = 'ad_ta_options.php'" type="button">Cancel</button>
                <br><br><br><br>
            </div>
        </form>
    </div>
</body>
</html>
