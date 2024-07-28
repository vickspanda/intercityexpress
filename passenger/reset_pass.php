<?php
    session_start();
    $pass_username = $_SESSION["reset_username"];
    if(!$pass_username)  {
        echo '<script>window.location.href="forgot_pass.html"</script>';
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <script src="../script/pass_validate.js" defer></script>
</head>
<body>
<nav>
            <ul>
                <li><a href="../index.html">HOME</a></li>
                <li><a href="#">ABOUT</a></li>
                <li><a href="../travel_agent/index.html">AGENT</a></li>
                <li><a href="../employee/index.html">EMPLOYEE</a></li>
                <li><a href="../passenger/index.html">PASSENGER</a></li>
                <li><a href="../admin/index.html">ADMIN</a></li>
                <li><a href="../process/schedule.html">SCHEDULE</a></li>
                <li><a href="../process/contact.php">CONTACT</a></li>
            </ul>
        </nav>
    <div class="background"></div>
    <div class="login_form">
        <form id="signUpForm" method="post" action="update_pass.php">
            <br><br>
            <div class="lbl2">
                <label>Reset Password</label><br><br><br>
            </div>
            <div class="credentials_forgot">
                <input type="username" name="pass_username" placeholder="<?php echo $pass_username; ?>" required readonly>
                <br><br><br>
                <input type="password" name="pass_password" placeholder="New Password" id="pass_password" autofocus required>
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
</body>
</html>
