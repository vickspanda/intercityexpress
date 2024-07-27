<?php
    session_start();
    if(isset($_SESSION["pass_username"])){
        $username = $_SESSION["pass_username"];
        $userType = 'passenger';
        $user = '../passenger/';
        $us = 'passenger';
    }
    if(isset($_SESSION["emp_username"])){
        $username = $_SESSION["emp_username"];
        $userType = 'employee';
        $user = '../employee/';
        $us = 'emp';

    }
    if(isset($_SESSION["ta_username"])){
        $username = $_SESSION["ta_username"];
        $userType = 'travel_agent';
        $user = '../travel_agent/';
        $us = 'ta';

    }
    include '../process/connect.php';
    include '../process/getUserStatus.php';


    
    if(!$username)  {
        echo '<script>window.location.href="../index.html"</script>';
      }
?>


<!DOCTYPE html>
    <head>
        <title>Change Password</title>
        <style>
        .error {
            color: white;
            display: none;
        }
        .invalid {
            border-color: red;
        }
    </style>
        <script src="../script/change_pass.js" defer></script>
        <link rel="stylesheet" href="../design/change_pass.css">
        <link rel="stylesheet" href="../design/home.css">
    </head>
    <body>
        <div class="background"></div>
        <div class="login_form">
            <form id="signUpForm" method="post" action="change_pass_update.php">
                <br><br>
                <div class="lbl2">
                    <label>Change Password</label><br><br><br>
                </div>
                <div class="credentials_forgot">
                    <input type="username" name="username" placeholder="<?php echo $username;?>" required readonly>
                    <br><br><br>
                    <input type="password" name="password" placeholder="New Password" id="pass_password" autofocus required>
                    <br>
                    <span class="error" id="passwordError">Password should be more than 8 characters</span>
                    <br><br>
                    <input type="password" placeholder="Confirm Password" id="confirm_password" required>
                    <br>
                    <span class="error" id="confirmPasswordError">Passwords do not match</span>
                    <br><br>
                </div>
                <div class="submit2">
                    <input type="submit" value="Update">
                    <button onclick="location.href='../<?php echo $userType?>/<?php echo $us?>_dashboard.php'" type="button" id="signup">Cancel</button>
                    <br><br><br>
                </div>
    </form>
        </div>
    </body>
</html>
