<?php

session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';


?>
<!DOCTYPE html>
    <head>
        <title>View Chart</title>
        <link rel="stylesheet" href="../design/login_page.css">
        <link rel="stylesheet" href="../design/home.css">
    <script src="../script/ad-train.js" defer></script>
    <style>
        .error {
            color: white;
            display: none;
        }
        .invalid {
            border-color: red;
        }
    </style>
    </head>
    <body>

        <div class="background"></div>
        <div class="login_form">
            <form id="signUpForm" method="post" action="ad_view_charts.php" onsubmit="return validateForm()">
                <br><br>
                <div class="lbl3">
                    <label>View Chart</label><br><br><br>
                </div>
                <div class="credentials">
                    <input type="text" name="train_no" placeholder="Enter Train's Number" id="train_no" autofocus  onblur="fetchDetails()" required>
                    <br><br>
                    <span class="error" id="trainNoError">Please Enter only Number</span>
                    <div id="trainMessage"></div><br>
                    <input type="text" name="doj" placeholder="Date of Journey" id="doj" onfocus="(this.type='date')" onblur="(this.type='text')" required>
                    <br><br><br>
                
                <div class="sec_book">
                <select name="coach_class" required>
                    <option value="" disabled hidden selected>All Classes</option>
                    <option value="AC Chair Car">AC Chair Car</option>
                    <option value="2S Sitting Car">2S Sitting Car</option>
                </select>
                    </div>
                    <br><br>
                </div>
                <div class="submit1">
                    <input type="submit" value="View">
                    <button type="button" onclick="location.href='ad_more_options.php'">Cancel</button>
                    <br><br><br>
                </div>
        </div>
    </body>
</html>
