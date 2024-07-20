<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

include '../process/connect.php';

if(isset($_GET["emp_username"]))
{
    $emp_username = $_GET["emp_username"];
    $blocked_users = "TRUE";
}
if(isset($_GET["emp_list"]))
{
    $emp_username = $_GET["emp_list"];
    $blocked_users = "LIST";
}
if(isset($_POST["username"]))
{
    $emp_username = $_POST["username"];
    $blocked_users = "FALSE";
}
if(!$emp_username){
    $emp_username = $_COOKIE['username'];
    $blocked_users = $_COOKIE['su'];
}
setcookie("username",$emp_username);
setcookie("su",$blocked_users);


function get_employee_data($conn, $emp_username, $field) {
    $query = "SELECT $field FROM employee WHERE username = $1";
    $result = pg_query_params($conn, $query, array($emp_username));
    if ($result && pg_num_rows($result) > 0) {
        return pg_fetch_result($result, 0, 0);
    } else {
        echo '<script>window.alert("User Not Found !!!"); window.location.href="ad_view_emp.php";</script>';
    }
}
$emp_des = get_employee_data($conn, $emp_username, 'emp_des');
$emp_name = get_employee_data($conn, $emp_username, 'emp_name');
$emp_qual = get_employee_data($conn, $emp_username, 'emp_qual');
$emp_date_of_joining = get_employee_data($conn, $emp_username, 'emp_date_of_joining');
$emp_dob = get_employee_data($conn, $emp_username, 'emp_date_of_birth');
$emp_gov_id = get_employee_data($conn, $emp_username, 'emp_gov_id');
$emp_id = get_employee_data($conn, $emp_username, 'emp_id');
$emp_gender = get_employee_data($conn, $emp_username, 'emp_gender');
$emp_status = get_employee_data($conn, $emp_username, 'status');

if($emp_gov_id === 'Elector Photo Identity Card')
{
    $emp_gov_id = 'Voter Id';
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
                Employee ID<br><br>
                Name <br><br>
                Date of Birth <br><br>
                Designation <br><br>
                Gender <br><br>
                Qualification <br><br>
                Date of Joining <br><br>
                <?php echo htmlspecialchars($emp_gov_id); ?><br><br>
                Account Status 
                
            </div>
            <div class="col3_ppv">
            <?php echo htmlspecialchars($emp_username); ?><br><br>
                <?php echo htmlspecialchars($emp_name); ?><br><br>
                <?php echo htmlspecialchars($emp_dob); ?><br><br>
                <?php echo htmlspecialchars($emp_des); ?><br><br>
                <?php echo htmlspecialchars($emp_gender); ?><br><br>
                <?php echo htmlspecialchars($emp_qual); ?><br><br>
                <?php echo htmlspecialchars($emp_date_of_joining); ?><br><br>
                <?php echo htmlspecialchars($emp_id); ?><br><br>
                <?php echo htmlspecialchars($emp_status)?> 

                
            </div>
        </footer>
        <div class="signup">
            <br>
            <button onclick="location.href='ad_emp_more.php'" type="button" id="signup1">Contact</button>
            <?php
            if($blocked_users === "TRUE"){
                ?>
                    <button onclick="location.href='ad_block_users.php?emp=emp'" type="button" id="signup1">Back</button>
                <?php
            }else if ($blocked_users === "FALSE")
            {
                ?>
                    <button onclick="location.href='ad_emp_options.php'" type="button" id="signup1">Back</button>
                <?php
            }
            else if ($blocked_users === "LIST")
            {
                ?>
                    <button onclick="location.href='ad_view_users.php?emp=emp'" type="button" id="signup1">Back</button>
                <?php
            }
            ?>
            <br><br><br>
        </div>
    </div>
</body>
</html>
