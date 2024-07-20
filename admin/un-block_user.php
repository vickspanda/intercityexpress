<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

echo "<!DOCTYPE html>
<html>
<head>
  <title>Blocking ...</title>
</head>
<body>
</body>
</html>";

include '../process/connect.php';


$username = $_POST["username"] ?? '';
$userType = $_POST["userType"] ?? '';
$do = $_POST["do"] ?? '' ;

$blocked_users = FALSE;
if(isset($_GET["pass_username"])){
    $username = $_GET["pass_username"];
    $userType = 'passenger';
    $do = 'Unblock';
    $next = 'pass=pass';
    $blocked_users = TRUE;
}

if(isset($_GET["ta_username"])){
    $username = $_GET["ta_username"];
    $userType = 'travel_agent';
    $do = 'Unblock';
    $next = 'ta=ta';
    $blocked_users = TRUE;
}

if(isset($_GET["emp_username"])){
    $username = $_GET["emp_username"];
    $userType = 'employee';
    $do = 'Unblock';
    $next = 'emp=emp';
    $blocked_users = TRUE;
}

if(isset($_GET["pass_list"])){
    $username = $_GET["pass_list"];
    $userType = 'passenger';
    $do = 'Block';
    $blocked_users = TRUE;
    $next = 'pass=pass';
}

if(isset($_GET["ta_list"])){
    $username = $_GET["ta_list"];
    $userType = 'travel_agent';
    $do = 'Block';
    $blocked_users = TRUE;
    $next = 'ta=ta';
}

if(isset($_GET["emp_list"])){
    $username = $_GET["emp_list"];
    $userType = 'employee';
    $do = 'Block';
    $blocked_users = TRUE;
    $next = 'emp=emp';
}

if(isset($_GET["ta_pend_username"])){
    $username = $_GET["ta_pend_username"];
    $userType = 'travel_agent';
    $do = 'Verify';
}



$check = "SELECT status FROM $userType WHERE username = '$username'";
$check_status = pg_query($conn, $check);

if ($check_status && pg_num_rows($check_status) > 0) {
    $row = pg_fetch_assoc($check_status);
    if($do === 'Block'){
        if ($row['status'] === 'Blocked') {
            if($blocked_users == FALSE){
                if ($userType === 'passenger') {
                    echo '<script>window.alert("Passenger is already Blocked !!!"); window.location.href="ad_block_pass.php";</script>';
                } elseif ($userType === 'travel_agent' ) {
                    echo '<script>window.alert("Travel Agent is already Blocked !!!"); window.location.href="ad_block_ta.php";</script>';
                } elseif ($userType === 'employee') {
                    echo '<script>window.alert("Employee is already Blocked !!!"); window.location.href="ad_block_emp.php";</script>';
                }
                exit();
            }else{
                echo '<script>window.location.href="ad_block_users.php?'.$next.'";</script>';
            }
        } else {
            $query = "UPDATE $userType SET status='Blocked' WHERE username='$username' and status='Active'";
            $block = pg_query($conn, $query);
    
            if ($block) {
                if($blocked_users == FALSE){
                    if ($userType === 'passenger') {
                        echo '<script>window.alert("Passenger has been Blocked !!!"); window.location.href="ad_pass_options.php";</script>';
                    } elseif ($userType === 'travel_agent') {
                        if($row['status'] === 'Active'){
                            echo '<script>window.alert("Travel Agent has been Blocked !!!"); window.location.href="ad_ta_options.php";</script>';
                        }else{
                            echo '<script>window.alert("Mentioned user is not Verfied Yet !!!"); window.location.href="ad_block_ta.php";</script>';
                        }
                    } elseif ($userType === 'employee') {
                        echo '<script>window.alert("Employee has been Blocked !!!"); window.location.href="ad_emp_options.php";</script>';
                    }
                }else if($blocked_users == TRUE){
                    echo '<script>window.location.href="ad_view_users.php?'.$next.'";</script>';
                }
            }
        }
    }else if($do === 'Unblock')
    {
        if ($row['status'] === 'Active') {
            if ($userType === 'passenger') {
                echo '<script>window.alert("Passenger is already Active !!!"); window.location.href="ad_unblock_pass.php";</script>';
            } elseif ($userType === 'travel_agent') {
                echo '<script>window.alert("Travel Agent is already Active !!!"); window.location.href="ad_unblock_ta.php";</script>';
            } elseif ($userType === 'employee') {
                echo '<script>window.alert("Employee is already Active !!!"); window.location.href="ad_unblock_emp.php";</script>';
            }
            exit();
        } else {
            $query = "UPDATE $userType SET status='Active' WHERE username='$username' and status='Blocked'";
            $block = pg_query($conn, $query);
    
            if ($block) {
                if($blocked_users == FALSE){
                    if ($userType === 'passenger') {
                        echo '<script>window.alert("Passenger has been Unblocked !!!"); window.location.href="ad_pass_options.php";</script>';
                    } elseif ($userType === 'travel_agent') {
                        if($row['status'] === 'Blocked'){
                            echo '<script>window.alert("Travel Agent has been Unblocked !!!"); window.location.href="ad_ta_options.php";</script>';
                        }else{
                            echo '<script>window.alert("Mentioned user is not Verfied Yet !!!"); window.location.href="ad_unblock_ta.php";</script>';
                        }
                    } elseif ($userType === 'employee') {
                        echo '<script>window.alert("Employee has been Unblocked !!!"); window.location.href="ad_emp_options.php";</script>';
                    }
                }else if($blocked_users == TRUE){
                    echo '<script>window.location.href="ad_block_users.php?'.$next.'";</script>';
                }
            }
        }
    }else if ($do === 'Verify')
    {
        $query = "UPDATE $userType SET status='Active' WHERE username='$username' and status='Not-verified'";
        $verify = pg_query($conn, $query);

        $query_name = "SELECT ta_name from travel_agent where username='$username'";
        $get_name = pg_query($conn, $query_name);

        $row = pg_fetch_assoc($get_name);
        $name = $row['ta_name'];


        if($verify){
            if($get_name){
                echo '<script>window.alert("'.$name.' has been Approved !!!"); window.location.href="ad_ta_approval.php";</script>';
            }
        }
    }
}
else {
    if($do === 'Block'){
        if ($userType === 'passenger') {
            echo '<script>window.alert("User Not Found !!!"); window.location.href="ad_pass_options.php";</script>';
        } elseif ($userType === 'travel_agent') {
            echo '<script>window.alert("User Not Found !!!"); window.location.href="ad_ta_options.php";</script>';
        } elseif ($userType === 'employee') {
            echo '<script>window.alert("User Not Found !!!"); window.location.href="ad_emp_options.php";</script>';
        }
    }else if ($do === 'Unblock')
    {
        if ($userType === 'passenger') {
            echo '<script>window.alert("User Not Found !!!"); window.location.href="ad_pass_options.php";</script>';
        } elseif ($userType === 'travel_agent') {
            echo '<script>window.alert("User Not Found !!!"); window.location.href="ad_ta_options.php";</script>';
        } elseif ($userType === 'employee') {
            echo '<script>window.alert("User Not Found !!!"); window.location.href="ad_emp_options.php";</script>';
        }
    }
}


pg_close($conn);
?>
