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
    <title>View History</title>
    <link rel="stylesheet" href="../design/un-block_user.css">
    <link rel="stylesheet" href="../design/home.css">
    <script src="../script/un-block.js" defer></script>

</head>
<body>
    <div class="background"></div>
    <div class="login_form">
        <form id="signUpForm" action="../process/list_tickets.php" method="post" onsubmit="validateForm(event)">
            <div class="lbl1">
                <br><br><br>
                <label>User's History !!!</label>
            </div>
            <div class="credentials">
            <br><br>
            <div class="sec_book">
                        <select id="userType" name="userType" required>
                            <option value="" disabled selected hidden>Select Your User Type</option>
                            <option value="passenger">Passenger</option>
                            <option value="employee">Employee</option>
                            <option value="travel_agent">Travel Agent</option>
                        </select>
                    </div><br><br>
                <input type="text" id="username" name="username" placeholder="Enter User's Username" onblur="validateUsername()" autofocus required>
                 <div id="usernameMessage"></div>
                
            </div><br><br>
            <div class="submit1">
                <input type="submit" value="View">
                <button onclick="location.href = 'ad_more.php'" type="button">Cancel</button><br><br><br><br>
            </div>
        </form>
    </div>
</body>
</html>
