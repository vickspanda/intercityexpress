<?php
session_start();
$ad_username = $_SESSION["admin_username"] ?? '';

include '../process/!admin_username.php';

include '../process/connect.php';


if(isset($_POST['userType'])){
    $user_type = $_POST['userType'];
}

if(isset($_POST['booking_limit'])){
    $booking_limit = $_POST['booking_limit'];
    $booking_limit = $booking_limit * 30;

    $updateLimit = "UPDATE limits SET booking_limit = $1 WHERE user_type = $2";
    $updateExe = pg_query_params($conn,$updateLimit,array($booking_limit,$user_type));
    if($updateExe){
        echo '<script>window.alert("Advance Booking Limit Successfully Updated for '.$user_type.'!!!"); window.location.href="ad_more.php";</script>';
    }else{
        echo '<script>window.alert("Got Some Technical Issues !!!"); window.location.href="ad_more.php";</script>';
    }
}


?>