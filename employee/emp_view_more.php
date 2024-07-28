<?php
session_start();
$emp_username = $_SESSION["emp_username"] ?? '';

include '../process/!emp_username';

include '../process/connect.php';
$username = $emp_username;
$userType = 'employee';
$_SESSION['userType'] = $userType;
include '../process/getUserStatus.php';



function get_employee_data($conn, $emp_username, $field) {
    $query = "SELECT $field FROM employee WHERE username = $1";
    $result = pg_query_params($conn, $query, array($emp_username));
    if ($result && pg_num_rows($result) > 0) {
        return pg_fetch_result($result, 0, 0);
    } else {
        echo '<script>window.alert("User Not Found !!!"); window.location.href="ad_view_emp.php";</script>';
    }
}
$emp_mobile_no = get_employee_data($conn, $emp_username, 'emp_mobile_no');
$emp_email_id = get_employee_data($conn, $emp_username, 'emp_email_id');
$emp_res_address = get_employee_data($conn, $emp_username, 'emp_res_address');
$emp_res_state = get_employee_data($conn, $emp_username, 'emp_res_state');
$emp_res_district = get_employee_data($conn, $emp_username, 'emp_res_district');
$emp_res_pincode = get_employee_data($conn, $emp_username, 'emp_res_pincode');
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
    <script src="../script/emp_logout.js" defer></script>

</head>
<body>
    <div class="bg_pass_account"></div>
    <div class="pass_account_ppv">
        <footer>
            <div class="col1">
            <div class="nav">
                    <ul>
                        <li><a href="../employee/emp_view_options.php">UPCOMING TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=PAST">PAST TRIPS</a></li>
                        <li><a href="../process/get_task.php?title=DOWNLOAD">DOWNLOAD</a></li>
                        <li><a href="../process/change_pass.php">CHANGE PASSWORD</a></li>
                        <li><a href="../employee/emp_view_profile.php">YOUR PROFILE</a></li>
                        <li><a href="../employee/emp_view_more.php">CONTACT DETAILS</a></li>
                        <li><a href="../process/feedback.php">FEEDBACK</a></li>
                        <li><a href="#" onclick="logout()">LOG OUT</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="col2_ppv"><br>
            <br><br><br>
                Mobile No. <br><br>
                Email Id <br><br>
                Address <br><br>
                
            </div>
            <div class="col3_ppv"><br>
            <br><br><br>
                +91 <?php echo htmlspecialchars($emp_mobile_no); ?><br><br>
                <?php echo htmlspecialchars($emp_email_id); ?><br><br>
                <?php echo htmlspecialchars($emp_res_address); ?>,<br> <?php echo htmlspecialchars($emp_res_district); ?>, <?php echo htmlspecialchars($emp_res_state); ?> <br> <?php echo htmlspecialchars($emp_res_pincode); ?>

                
            </div>
        </footer>
        <div class="signup">
            <br>
            <button onclick="location.href='update_emp_profile.php?part=more'" type="button" id="signup1">UPDATE</button>
            <br><br><br>
        </div>
    </div>
</body>
</html>
