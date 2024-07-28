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
        exit();
    }
}

$ta_name = get_ta_data($conn, $ta_username, 'ta_name');
$ta_dob = get_ta_data($conn, $ta_username, 'ta_date_of_birth');
$ta_age_query = pg_query_params($conn, "SELECT AGE(ta_date_of_birth) FROM travel_agent WHERE username = $1", array($ta_username));
$ta_age = pg_fetch_result($ta_age_query, 0, 0);
$ta_gov_id = get_ta_data($conn, $ta_username, 'ta_gov_id');
$ta_id = get_ta_data($conn, $ta_username, 'ta_id');
$ta_gender = get_ta_data($conn, $ta_username, 'ta_gender');
$ta_status = get_ta_data($conn, $ta_username, 'status');
$ta_com_address = get_ta_data($conn, $ta_username, 'ta_com_address');
$ta_com_state = get_ta_data($conn, $ta_username, 'ta_com_state');
$ta_com_district = get_ta_data($conn, $ta_username, 'ta_com_district');
$ta_com_pincode = get_ta_data($conn, $ta_username, 'ta_com_pincode');

if ($ta_gov_id === 'Elector Photo Identity Card') {
    $ta_gov_id = 'Voter Id';
}

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
            <div class="col2_ppv">
                Name <br><br>
                Date of Birth <br><br>
                Age <br><br>
                Gender <br><br>
                <?php echo htmlspecialchars($ta_gov_id); ?><br><br>
                Account Status <br><br>
                Commercial Address <br><br>
            </div>
            <div class="col3_ppv">
                <?php echo htmlspecialchars($ta_name); ?><br><br>
                <?php echo htmlspecialchars($ta_dob); ?><br><br>
                <?php echo htmlspecialchars($ta_age); ?><br><br>
                <?php echo htmlspecialchars($ta_gender); ?><br><br>
                <?php echo htmlspecialchars($ta_id); ?><br><br>
                <?php echo htmlspecialchars($ta_status); ?><br><br>
                <?php echo htmlspecialchars($ta_com_address); ?>,<br>
                <?php echo htmlspecialchars($ta_com_district); ?>,
                <?php echo htmlspecialchars($ta_com_state); ?><br>
                <?php echo htmlspecialchars($ta_com_pincode); ?>
            </div>
        </footer>
        <div class="signup">
            <br>
            <button onclick="location.href='update_ta_profile.php?part=profile'" type="button" id="signup1">UPDATE</button>
            <br><br><br>
        </div>
    </div>
</body>
</html>
