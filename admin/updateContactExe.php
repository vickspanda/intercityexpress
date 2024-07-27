<?php
    session_start();
    $ad_username = $_SESSION["admin_username"] ?? '';

    include '../process/!admin_username.php';

    echo "<!DOCTYPE html>
    <html>
    <head>
    <title>Updating ...</title>
    </head>
    <body>
    </body>
    </html>";

    include '../process/connect.php';

    $address = $_POST["p_address"] ?? '';
    $state = $_POST["p_state"] ?? '';
    $district = $_POST["p_district"] ?? '';
    $pincode = $_POST["p_pincode"] ?? '';
    $mobile = $_POST["p_mobile"] ?? '';
    $email = $_POST["p_email"] ?? '';

    $updateContactQuery = "UPDATE contact SET address = $1,mobile_no = $2, email_id = $3, state = $4, district = $5, pincode = $6 WHERE uid = $7";
    $updateContactArray = array($address,$mobile,$email,$state,$district,$pincode,1);
    $updateContactExe = pg_query_params($conn, $updateContactQuery, $updateContactArray);

    if($updateContactExe){
        echo '<script>window.alert("Contact Details have been Successfully Updated !!!"); window.location.href="ad_more.php";</script>';
    }
    else{
        echo '<script>window.alert("Got Some Technical Issues !!!"); window.location.href="ad_more.php";</script>';
    }





?>