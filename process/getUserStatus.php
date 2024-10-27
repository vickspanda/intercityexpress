<?php 

    $getUserStatus = "SELECT status FROM $userType WHERE username = $1";
    $getStatusExe = pg_query_params($conn, $getUserStatus, array($username));
    if($getStatusExe){
        $getStatusRow = pg_fetch_assoc($getStatusExe);
        $status = $getStatusRow['status'];
        if($status === 'Blocked'){
            echo '<script>window.location.href="../process/block_alert.php";</script>';
        }
        if($status === 'Not-verified'){
            echo '<script>window.location.href="../travel_agent/ta_alert.php";</script>';
        }
    }
?>
