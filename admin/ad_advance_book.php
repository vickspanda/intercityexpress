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
    <title>Set Advance Booking</title>
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
                <label>Set Advance Booking</label>
            </div>
            <div class="credentials">
            <br><br>
            <input type="number" id="booking_limit" name="booking_limit" placeholder="Enter Number of Days" autofocus required>

            <br><br><br>
                 <div class="sec_book">
                        <select id="userType" name="userType" required>
                            <option value="" disabled selected hidden>Select Your User Type</option>
                            <option value="passenger">Passenger</option>
                            <option value="employee">Employee</option>
                            <option value="travel_agent">Travel Agent</option>
                        </select>
                    </div>
                
            </div><br><br>
            <div class="submit1">
                <input type="submit" value="Set">
                <button onclick="location.href = 'ad_more.php'" type="button">Cancel</button><br><br><br><br>
            </div>
        </form>
    </div>
</body>
</html>
