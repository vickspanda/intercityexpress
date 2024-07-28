<?php
    session_start();
    $emp_username = $_SESSION["reset_emp_username"];
    if(!$emp_username)  {
        echo '<script>window.location.href="forgot_emp.html"</script>';
      }
?>


<!DOCTYPE html>
    <head>
        <title>Reset Password</title>
        <style>
        .error {
            color: white;
            display: none;
        }
        .invalid {
            border-color: red;
        }
    </style>
        <link rel="stylesheet" href="../design/change_pass.css">
        <link rel="stylesheet" href="../design/home.css">
    </head>
    <body>
    <nav>
        <ul>
            <li><a href="../">HOME</a></li>
            <li><a href="../process/">ABOUT</a></li>
            <li><a href="../travel_agent/">AGENT</a></li>
            <li><a href="../employee/">EMPLOYEE</a></li>
            <li><a href="../passenger/">PASSENGER</a></li>
            <li><a href="../admin/">ADMIN</a></li>
            <li><a href="../process/schedule.html">SCHEDULE</a></li>
            <li><a href="../process/contact.php">CONTACT</a></li>
        </ul>
    </nav>
        <div class="background"></div>
        <div class="login_form">
            <form id="signUpForm" method="post" action="update_emp.php">
                <br><br>
                <div class="lbl2">
                    <label>Reset Password</label><br><br><br>
                </div>
                <div class="credentials_forgot">
                    <input type="username" name="emp_username" placeholder="<?php echo $emp_username;?>" required readonly>
                    <br><br><br>
                    <input type="password" name="emp_password" placeholder="New Password" id="emp_password" autofocus required>
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
                    <button onclick="location.href='index.html'" type="button" id="signup">Cancel</button>
                    
                    <br><br><br>
                </div>
    </form>
        </div>
        <script src="../script/emp_validate.js"></script>
    </body>
</html>
