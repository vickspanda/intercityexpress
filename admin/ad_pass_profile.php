<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

include '../process/connect.php';

if(isset($_GET["pass_username"]))
{
    $pass_username = $_GET["pass_username"];
    $blocked_users = "TRUE";
}
if(isset($_GET["pass_list"]))
{
    $pass_username = $_GET["pass_list"];
    $blocked_users = "LIST";
}
if(isset($_POST["username"]))
{
    $pass_username = $_POST["username"];
    $blocked_users = "FALSE";
}


function get_passenger_data($conn, $pass_username, $field) {
    $query = "SELECT $field FROM passenger WHERE username = $1";
    $result = pg_query_params($conn, $query, array($pass_username));
    if ($result && pg_num_rows($result) > 0) {
        return pg_fetch_result($result, 0, 0);
    } else {
        echo '<script>window.alert("User Not Found !!!"); window.location.href="ad_view_pass.php";</script>';
    }
}

$pass_name = get_passenger_data($conn, $pass_username, 'name');
$pass_address = get_passenger_data($conn, $pass_username, 'address');
$pass_district = get_passenger_data($conn, $pass_username, 'district');
$pass_state = get_passenger_data($conn, $pass_username, 'state');
$pass_pincode = get_passenger_data($conn, $pass_username, 'pincode');
$pass_mobile_no = get_passenger_data($conn, $pass_username, 'mobile_no');
$pass_email_id = get_passenger_data($conn, $pass_username, 'email_id');
$pass_dob = get_passenger_data($conn, $pass_username, 'date_of_birth');
$pass_age_query = pg_query_params($conn, "SELECT AGE(date_of_birth) FROM passenger WHERE username = $1", array($pass_username));
$pass_age = pg_fetch_result($pass_age_query, 0, 0);
$pass_gender = get_passenger_data($conn, $pass_username, 'gender');
$pass_status = get_passenger_data($conn, $pass_username, 'status');

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/pa_acc.css">
    <link rel="stylesheet" href="../design/pass_ppv.css">

    <title>View Profile</title>
    <script src="../script/admin_logout.js"></script>


</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <footer>
        <div class="col1">
                <div class="nav">
                    <ul>
                        <li><a href="ad_pass_options.php">PASSENGERS</a></li>
                        <li><a href="ad_ta_options.php">TRAVEL AGENTS</a></li>
                        <li><a href="ad_emp_options.php">EMPLOYEES</a></li>
                        <li><a href="ad_train_options.php">TRAINS</a></li>
                        <li><a href="ad_station_options.php">STATIONS</a></li>
                        <li><a href="ad_view_options.php" >VIEW USERS</a></li>
                        <li><a href="ad_more_options.php" >MORE OPTIONS</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            <div class="col2_ppv">
                Name <br><br>
                Date of Birth <br><br>
                Age <br><br>
                Gender <br><br>
                Mobile No. <br><br>
                Email Id <br><br>
                Account Status <br><br>
                Address <br><br>
                
            </div>
            <div class="col3_ppv">
                <?php echo htmlspecialchars($pass_name); ?><br><br>
                <?php echo htmlspecialchars($pass_dob); ?><br><br>
                <?php echo htmlspecialchars($pass_age); ?><br><br>
                <?php echo htmlspecialchars($pass_gender); ?><br><br>
                +91 <?php echo htmlspecialchars($pass_mobile_no); ?><br><br>
                <?php echo htmlspecialchars($pass_email_id); ?><br><br>
                <?php echo htmlspecialchars($pass_status)?> <br><br>
                <?php echo htmlspecialchars($pass_address); ?>,<br> <?php echo htmlspecialchars($pass_district); ?>, <?php echo htmlspecialchars($pass_state); ?>  <?php echo htmlspecialchars($pass_pincode); ?>
                
            </div>
        </footer>
        <div class="signup">
            <br>
            <?php
            if($blocked_users === "TRUE"){
                ?>
                    <button onclick="location.href='ad_block_users.php?pass=pass'" type="button" id="signup1">Back</button>
                <?php
            }else if ($blocked_users === "FALSE")
            {
                ?>
                    <button onclick="location.href='ad_pass_options.php'" type="button" id="signup1">Back</button>
                <?php
            }
            else if ($blocked_users === "LIST")
            {
                ?>
                    <button onclick="location.href='ad_view_users.php?pass=pass'" type="button" id="signup1">Back</button>
                <?php
            }
            ?>
            <br><br><br>
        </div>
    </div>
</body>
</html>
