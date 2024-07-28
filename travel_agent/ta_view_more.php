<?php
session_start();
$ta_username = $_SESSION["ta_username"] ?? '';

include '../process/!ta_username.php';


include '../process/connect.php';
$username = $ta_username;
$userType = 'travel_agent';
$_SESSION['userType'] = $userType;
include '../process/getUserStatus.php';

function get_ta_data($conn, $ta_username, $field) {
    $query = "SELECT $field FROM travel_agent WHERE username = $1";
    $result = pg_query_params($conn, $query, array($ta_username));
    if ($result && pg_num_rows($result) > 0) {
        return pg_fetch_result($result, 0, 0);
    } else {
        echo '<script>window.alert("User Not Found !!!"); window.location.href="ad_view_ta.php";</script>';
    }
}
$ta_mobile_no = get_ta_data($conn, $ta_username, 'ta_mobile_no');
$ta_email_id = get_ta_data($conn, $ta_username, 'ta_email_id');
$ta_res_address = get_ta_data($conn, $ta_username, 'ta_res_address');
$ta_res_state = get_ta_data($conn, $ta_username, 'ta_res_state');
$ta_res_district = get_ta_data($conn, $ta_username, 'ta_res_district');
$ta_res_pincode = get_ta_data($conn, $ta_username, 'ta_res_pincode');


pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/pa_acc.css">
    <link rel="stylesheet" href="../design/pass_ppv.css">
    <title>Dashboard</title>
    <script src="../script/ta_logout.js" defer></script>

</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <footer>
            <div class="col1">
            <div class="nav">
                    <ul>
                        <li><a href="../travel_agent/ta_view_options.php">UPCOMING TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=PAST">PAST TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=DOWNLOAD">DOWNLOAD</a></li>
                        <li><a href="../process/change_pass.php">CHANGE PASSWORD</a></li>
                        <li><a href="../travel_agent/ta_view_profile.php">YOUR PROFILE</a></li>
                        <li><a href="../travel_agent/ta_view_more.php">CONTACT DETAILS</a></li>
                        <li><a href="../process/feedback.php">FEEDBACK</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            <div class="col2_ppv"><br>
            <br><br><br>
            Username <br><br>

                Mobile No. <br><br>
                Email Id <br><br>
                Residential Address <br><br>
                
            </div>
            <div class="col3_ppv"><br>
            <br><br><br>
            <?php echo htmlspecialchars($ta_username); ?><br><br>

                +91 <?php echo htmlspecialchars($ta_mobile_no); ?><br><br>
                <?php echo htmlspecialchars($ta_email_id); ?><br><br>
                <?php echo htmlspecialchars($ta_res_address); ?>,<br> <?php echo htmlspecialchars($ta_res_district); ?>, <?php echo htmlspecialchars($ta_res_state); ?> <br> <?php echo htmlspecialchars($ta_res_pincode); ?>

                
            </div>
        </footer>
        <div class="signup">
            <br>
            <button onclick="location.href='update_ta_profile.php?part=more'" type="button" id="signup1">UPDATE</button>
            <br><br><br>
        </div>
    </div>
</body>
</html>
