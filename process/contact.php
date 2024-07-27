<?php
    include 'connect.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/home.css">
    <link rel="stylesheet" href="../design/pass_account.css">
    <link rel="stylesheet" href="../design/ad_view_pass_more.css">
    <title>Contact Us</title>
</head>
<body>
        <nav>
            <img src="../images/logo.png" class="img" alt="logo">
            <ul>
                <li><a href="../index.html">HOME</a></li>
                <li><a href="#">ABOUT</a></li>
                <li><a href="../travel_agent/index.html">AGENT</a></li>
                <li><a href="../employee/index.html">EMPLOYEE</a></li>
                <li><a href="../passenger/index.html">PASSENGER</a></li>
                <li><a href="../admin/index.html">ADMIN</a></li>
                <li><a href="#">FACILITIES</a></li>
                <li><a href="#">SCHEDULE</a></li>
                <li><a href="../process/connect.php">CONTACT</a></li>
            </ul>
        </nav>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <h1 style="text-align: center;">Contact Us !!!</h1>
        <footer>
            <div class="col2_ppv"><br>
                Mobile No. <br><br>
                Email Id <br><br>
                Address <br><br>
                
            </div>
            <div class="col3_ppv"><br>
                +91 <?php echo htmlspecialchars($mobile_no); ?><br><br>
                <?php echo htmlspecialchars($email_id); ?><br><br>
                <?php echo htmlspecialchars($address); ?>,<br> <?php echo htmlspecialchars($district); ?>, <?php echo htmlspecialchars($state); ?> <br> <?php echo htmlspecialchars($pincode); ?>

                
            </div>
        </footer>
        <div class="signup">
            <br><br>
            <button onclick="location.href='../index.html'" type="button" id="signup1">Close</button>
            <br><br><br>
        </div>
    </div>
</body>
</html>