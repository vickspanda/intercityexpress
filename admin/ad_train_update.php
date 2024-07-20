<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

include '../process/connect.php';


// Close the connection after use
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/sign_up.css">
    <title>UPDATE TRAIN</title>
    <style>
        .error {
            color: white;
            display: none;
        }
        .invalid {
            border-color: red;
        }
    </style>
    <script src="../script/ad_train_update.js" defer></script>
</head>
<body>
    <div class="bg-image"></div>
    <div class="create_account">
        <form id="signUpForm" action="add_rem_trains.php" method="post" onsubmit="return validateForm()">
            <br>
            <div class="heading">
                <label>Update Train</label>
            </div>
            <br>
            <footer>
                <div class="col1">
                    <div class="fields1">
                        <input type="text" name="train_no" placeholder="Enter Train Number" id="train_no" onblur="fetchDetails()" required><br>
                        <span class="error" id="trainNoError">Please Enter only Number</span>
                        <div id="trainMessage"></div><br><br>
                        
                        <input type="text" name="from_station" id="from_station" placeholder="Start Station" readonly required><br><br><br>
                        
                        <input type="text" name="train_name" placeholder="Enter Train's Name" id="train_name" required><br>
                        <span class="error" id="trainNameError">Train Name should be less than 100 characters</span>
                        <br><br>
                        <input type="text" name="SS_fare" placeholder="Enter Second Sitting Fare (in Rs.)" id="SS_fare" required><br>
                        <span class="error" id="SS_fareError">Please Enter only Number</span>
                        <br><br>
                    </div>
                </div>
                <div class="col2">
                    <div class="fields2">
                        <input type="text" name="route_code" placeholder="Route Number" id="route_code" readonly required><br>
                        <div id="routeMessage"></div><br><br>   
                        <input type="text" name="to_station" id="to_station" placeholder="End Station" readonly required><br><br><br>
                        <input type="text" name="dep" placeholder="Enter Departure Time" id="dep" onfocus="(this.type='time')" onblur="(this.type='text')" required><br>
                        <span class="error" id="depError">Valid Time is required</span><br><br>
                        <input type="text" name="AC_fare" placeholder="Enter AC Sitting Fare (in Rs.)" id="AC_fare" required><br>
                        <span class="error" id="AC_fareError">Please Enter only Number</span>
                        <br><br>
                    </div>
                </div>
            </footer>
            <div class="days">
                Runs On :
                <input type="checkbox" name="mon" value="TRUE" > Monday
                <input type="checkbox" name="tue" value="TRUE" > Tuesday
                <input type="checkbox" name="wed" value="TRUE" > Wednesday
                <input type="checkbox" name="thu" value="TRUE" > Thursday
                <input type="checkbox" name="fri" value="TRUE" > Friday
                <input type="checkbox" name="sat" value="TRUE" > Saturday
                <input type="checkbox" name="sun" value="TRUE" > Sunday
                <br><br><div id="checkboxError" class="error">Please select at least one day.</div>
            </div>
            <input type="text" id="do" name="do" value="Update" hidden><br>
            <div class="signup">
                <input type="submit" value="Update">
                <button onclick="location.href = 'ad_train_options.php'" type="button">Cancel</button><br><br><br>
            </div>
        </form>
    </div>
</body>
</html>
