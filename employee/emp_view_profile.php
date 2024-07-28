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
$emp_des = get_employee_data($conn, $emp_username, 'emp_des');
$emp_name = get_employee_data($conn, $emp_username, 'emp_name');
$emp_qual = get_employee_data($conn, $emp_username, 'emp_qual');
$emp_date_of_joining = get_employee_data($conn, $emp_username, 'emp_date_of_joining');
$emp_dob = get_employee_data($conn, $emp_username, 'emp_date_of_birth');
$emp_gov_id = get_employee_data($conn, $emp_username, 'emp_gov_id');
$emp_id = get_employee_data($conn, $emp_username, 'emp_id');
$emp_gender = get_employee_data($conn, $emp_username, 'emp_gender');


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
            <div class="col2_ppv">
                Employee ID<br><br>
                Name <br><br>
                Date of Birth <br><br>
                Designation <br><br>
                Gender <br><br>
                Qualification <br><br>
                Date of Joining <br><br>
                <?php echo htmlspecialchars($emp_gov_id); ?>
                
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

                
            </div>
        </footer>
        <div class="signup">
            <br>
            <button onclick="location.href='update_emp_profile.php?part=profile'" type="button" id="signup1">UPDATE</button>
            <br><br><br>
        </div>
    </div>
</body>
</html>
