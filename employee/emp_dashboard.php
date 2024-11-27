<?php
session_start();
$emp_username = $_SESSION["emp_username"] ?? '';
include '../process/connect.php';
include '../process/!emp_username';
$username = $emp_username;
$userType = 'employee';
$_SESSION['userType'] = $userType;
include '../process/getUserStatus.php';


$get_emp_name = "SELECT emp_name FROM employee WHERE username=$1";
$emp_name_query = pg_query_params($conn, $get_emp_name, array($emp_username));

if (!$emp_name_query) {
    die("Query failed: " . pg_last_error());
}

$emp_name_result = pg_fetch_row($emp_name_query);

if (!$emp_name_result) {
    die("No employee found with the provided username.");
}

pg_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/emp_account.css">
    <title>Dashboard</title>
    <script src="../script/emp_logout.js" defer></script>


</head>
<body>
    <div class="bg_admin_account"></div>
    <div class="admin_account">
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
            <div class="col2">
                <div class="welcome">
                    Welcome <?php echo htmlspecialchars($emp_name_result[0], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
