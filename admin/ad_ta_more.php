<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

include '../process/connect.php';


$ta_username = $_COOKIE["username"];

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
    <link rel="stylesheet" href="../design/pass_account.css">
    <link rel="stylesheet" href="../design/ad_view_pass_more.css">
    <title>View Profile</title>
</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <footer>
            <div class="col2_ppv"><br>
                Mobile No. <br><br>
                Email Id <br><br>
                Residential Address <br><br>
                
            </div>
            <div class="col3_ppv"><br>
                +91 <?php echo htmlspecialchars($ta_mobile_no); ?><br><br>
                <?php echo htmlspecialchars($ta_email_id); ?><br><br>
                <?php echo htmlspecialchars($ta_res_address); ?>,<br> <?php echo htmlspecialchars($ta_res_district); ?>, <?php echo htmlspecialchars($ta_res_state); ?> <br> <?php echo htmlspecialchars($ta_res_pincode); ?>

                
            </div>
        </footer>
        <div class="signup">
            <br><br>
            <button onclick="location.href='ad_ta_profile.php'" type="button" id="signup1">Back</button>
            <br><br><br>
        </div>
    </div>
</body>
</html>
