<?php
echo "<!DOCTYPE html>
<html>
<head>
  <title>Signing Up ...</title>
</head>
<body>
</body>
</html>";

include '../process/connect.php';

$sign_up_conn = $conn;

$p_name = $_POST["p_name"] ?? '';
$p_address = $_POST["p_address"] ?? '';
$p_state = $_POST["p_state"] ?? '';
$p_district = $_POST["p_district"] ?? '';
$p_pincode = $_POST["p_pincode"] ?? '';
$p_dob = $_POST["p_dob"] ?? '';
$p_mobile = $_POST["p_mobile"] ?? '';
$p_email = $_POST["p_email"] ?? '';
$p_gender = $_POST["p_gender"] ?? '';
$p_username = $_POST["p_username"] ?? '';
$p_password = $_POST["p_password"] ?? '';
$p_secq = $_POST["p_secq"] ?? '';
$p_seca = $_POST["p_seca"] ?? '';


if(isset($_GET["part"])){
    $past = $_GET["part"];
    session_start();
    $pass_username = $_SESSION["pass_username"] ?? '';
    
    if (!$pass_username) {
        echo '<script>window.location.href="index.html";</script>';
        exit();
    }

    $update_profile = "UPDATE passenger SET 
                address = $1,
                state = $2,
                district = $3,
                pincode = $4,
                mobile_no = $5,
                email_id = $6,
                name = $7,
                gender = $8,
                date_of_birth = $9
                WHERE username = $10";

        $stmt = pg_prepare($sign_up_conn, "update_query", $update_profile);

        $result = pg_execute($sign_up_conn, "update_query", array(
            $p_address,
            $p_state,
            $p_district,
            $p_pincode,
            $p_mobile,
            $p_email,
            $p_name,
            $p_gender,
            $p_dob,
            $pass_username
        ));
        
        if($result){
            echo '<script>window.alert("Your Profile is Successfully Updated !!!"); window.location.href="passenger_view_profile.php";</script>';
        }else {
            echo "Error: " . pg_last_error($ta_conn);
        }

}else{
$status = 'Active';
$p_hashed_password = password_hash($p_password, PASSWORD_DEFAULT);
$p_hashed_seca = password_hash($p_seca, PASSWORD_DEFAULT);
$p_hashed_secq = password_hash($p_secq, PASSWORD_DEFAULT);


$sign_up_query = "INSERT INTO passenger (name, address, state, district, pincode, date_of_birth, mobile_no, email_id, gender, username, password, sec_ques, sec_ans,status) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14)";
$sign_up_params = array($p_name, $p_address, $p_state, $p_district, $p_pincode, $p_dob, $p_mobile, $p_email, $p_gender, $p_username, $p_hashed_password, $p_hashed_secq, $p_hashed_seca, $status);
$sign_up_execute = pg_query_params($sign_up_conn, $sign_up_query, $sign_up_params);

if ($sign_up_execute) {
    echo '<script>window.alert("You are successfully Registered !!!"); window.location.href="index.html";</script>';
} else {
    echo '<script>window.alert("Got some technical Failure !!!"); window.location.href="sign_up.html";</script>';
    echo "Error: " . pg_last_error($sign_up_conn);
}
}

pg_close($sign_up_conn);
?>
