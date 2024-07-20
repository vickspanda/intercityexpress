<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

include '../process/connect.php';


if(isset($_GET["ta_username"]))
{
    $ta_username = $_GET["ta_username"];
    $blocked_users = "TRUE";
}
if(isset($_GET["ta_list"]))
{
    $ta_username = $_GET["ta_list"];
    $blocked_users = "LIST";
}
if(isset($_GET["ta_pend_username"]))
{
    $ta_username = $_GET["ta_pend_username"];
    $blocked_users = "PEND";
}

if(isset($_POST["username"]))
{
    $ta_username = $_POST["username"];
    $blocked_users = "FALSE";
}
if(!$ta_username){
    $ta_username = $_COOKIE['username'];
    $blocked_users = $_COOKIE['su'];
}
setcookie("username",$ta_username);
setcookie("su",$blocked_users);

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
    <title>View Profile</title>
    <script src="../script/admin_logout.js" defer></script>


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
                Username <br><br>
                Name <br><br>
            Date of Birth <br><br>
                
                Gender <br><br>
                <?php echo htmlspecialchars($ta_gov_id); ?><br><br>
                Account Status <br><br>
                Commercial Address <br><br>
            </div>
            <div class="col3_ppv">
                <?php echo htmlspecialchars($ta_username); ?><br><br>
                <?php echo htmlspecialchars($ta_name); ?><br><br>
                <?php echo htmlspecialchars($ta_dob); ?><br><br>
                
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
            <br><br>
            <button onclick="location.href='ad_ta_more.php'" type="button" id="signup1">Contact</button>
            <?php 
            if($blocked_users === "TRUE"){
                ?>
                    <button onclick="location.href='ad_block_users.php?ta=ta'" type="button" id="signup1">Back</button>
                <?php
            }else if ($blocked_users === "FALSE")
            {
                ?>
                    <button onclick="location.href='ad_ta_options.php'" type="button" id="signup1">Back</button>
                <?php
            }
            else if($blocked_users === "PEND")
            {
                ?>
                <button onclick="location.href='ad_ta_approval.php'" type="button" id="signup1">Back</button>
            <?php
            }
            else if($blocked_users === "LIST")
            {
                ?>
                <button onclick="location.href='ad_view_users.php?ta=ta'" type="button" id="signup1">Back</button>
            <?php
            }
            ?>
            
            <br><br><br>
        </div>
    </div>
</body>
</html>
