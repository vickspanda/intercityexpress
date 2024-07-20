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
    <title>ADD STATION</title>
    <link rel="stylesheet" href="../design/un-block_user.css">
    <link rel="stylesheet" href="../design/home.css">
    <script src="../script/station.js" defer></script>
</head>
<body>
    <div class="background"></div>
    <div class="login_form">
        <form id="signUpForm" action="add_rem_stations.php" method="post" onsubmit="validateForm(event)">
            <div class="lbl1">
                <br><br><br>
                <label>Add Station !!!</label>
            </div>
            <div class="credentials">
            <br><br>
                <input type="text" id="username" name="username" placeholder="Enter Station's Name" onblur="validateUsername()" autofocus required>
                <br><br> <div id="usernameMessage"></div>
                <input type="text" id="userType" name="userType" value="stations" hidden>
                <input type="text" id="do" name="do" value="ADD" hidden><br>
                <div class="drop_down">
                    <select id="state" name="state" class="state" required>
                        <option value="" disabled selected hidden>Select State</option>
                        <option>Andaman and Nicobar Islands</option>
                        <option>Andhra Pradesh</option>
                        <option>Arunachal Pradesh</option>
                        <option>Assam</option>
                        <option>Bihar</option>
                        <option>Chandigarh</option>
                        <option>Chhattisgarh</option>
                        <option>Dadra and Nagar Haveli and Daman And Diu</option>
                        <option>Delhi</option>
                        <option>Goa</option>
                        <option>Gujarat</option>
                        <option>Haryana</option>
                        <option>Himachal Pradesh</option>
                        <option>Jharkhand</option>
                        <option>Jammu and Kashmir</option>
                        <option>Ladakh</option>
                        <option>Lakshadweep</option>
                        <option>Karnataka</option>
                        <option>Kerala</option>
                        <option>Madhya Pradesh</option>
                        <option>Maharashtra</option>
                        <option>Manipur</option>
                        <option>Meghalaya</option>
                        <option>Mizoram</option>
                        <option>Nagaland</option>
                        <option>Odisha</option>
                        <option>Puducherry</option>
                        <option>Punjab</option>
                        <option>Rajasthan</option>
                        <option>Sikkim</option>
                        <option>Tamil Nadu</option>
                        <option>Telangana</option>
                        <option>Tripura</option>
                        <option>Uttarakhand</option>
                        <option>Uttar Pradesh</option>
                        <option>West Bengal</option>
                    </select>
            </div><br><br>
            <input type="text" id="pltfno" name="pltfno" placeholder="Enter No. of Platforms" required>
            <div class="submit0">
            <br><br>
                <input type="submit" value="ADD">
                <button onclick="location.href = 'ad_station_options.php'" type="button">Cancel</button><br><br><br><br>
            </div>
        </form>
    </div>
</body>
</html>
