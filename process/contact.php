<?php
    include 'connect.php';

    $getContactQuery = "SELECT * FROM contact WHERE uid = $1";
    $getContactExe = pg_query_params($conn, $getContactQuery,array(1));
    if($getContactExe){
        $getContactRow = pg_fetch_assoc($getContactExe);
        $mobile_no = $getContactRow['mobile_no'];
        $email_id = $getContactRow['email_id'];
        $address = $getContactRow['address'];
        $district = $getContactRow['district'];
        $state = $getContactRow['state'];
        $pincode = $getContactRow['pincode'];
    }
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
            <ul>
                <li><a href="../index.html">HOME</a></li>
                <li><a href="../process/">ABOUT</a></li>
                <li><a href="../travel_agent/index.html">AGENT</a></li>
                <li><a href="../employee/index.html">EMPLOYEE</a></li>
                <li><a href="../passenger/index.html">PASSENGER</a></li>
                <li><a href="../admin/index.html">ADMIN</a></li>
                <li><a href="../process/schedule.html">SCHEDULE</a></li>
                <li><a href="../process/contact.php">CONTACT</a></li>
            </ul>
        </nav>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <h1 style="text-align: center;">Contact Us !!!</h1>
        <footer>
            <div class="col2_ppv">
                Mobile No. <br><br>
                Email Id <br><br>
                Address <br><br>
                
            </div>
            <div class="col3_ppv">
                +91 <?php echo htmlspecialchars($mobile_no); ?><br><br>
                <?php echo htmlspecialchars($email_id); ?><br><br>
                <?php echo htmlspecialchars($address); ?>,<br> <?php echo htmlspecialchars($district); ?>, <?php echo htmlspecialchars($state); ?> <br> <?php echo htmlspecialchars($pincode); ?>

                
            </div>
        </footer>
            <br><br>

    </div>
</body>
</html>
