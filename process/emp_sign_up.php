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


$emp_name = $_POST["fullName"] ?? '';
$emp_res_address = $_POST["address"] ?? '';
$emp_res_state = $_POST["state"] ?? '';
$emp_res_district = $_POST["district"] ?? '';
$emp_res_pincode = $_POST["pinCode"] ?? '';
$emp_date_of_birth = $_POST["dob"] ?? '';
$emp_mobile_no = $_POST["mobile"] ?? '';
$emp_email_id = $_POST["email"] ?? '';
$emp_gender = $_POST["gender"] ?? '';
$emp_qual = $_POST["qualification"] ?? '';
$emp_date_of_joining = $_POST["doj"] ?? '';
$emp_gov_id = $_POST["govtId"] ?? '';
$emp_id = $_POST["idNumber"] ?? '';
$emp_des = $_POST["designation"] ?? '';
$emp_password = $_POST["password"] ?? '';

if (isset($_GET["part"])) {
    session_start();
    $emp_username = $_SESSION["emp_username"] ?? '';
    
    include '../!emp_username.php';
    $part = $_GET["part"];

    if ($part === 'more') {
        $update_more = "UPDATE employee SET 
                emp_res_address = $1,
                emp_res_state = $2,
                emp_res_district = $3,
                emp_res_pincode = $4,
                emp_mobile_no = $5,
                emp_email_id = $6 
                WHERE username = $7";

        $stmt = pg_prepare($conn, "update_query", $update_more);

        $result = pg_execute($conn, "update_query", array(
            $emp_res_address,
            $emp_res_state,
            $emp_res_district,
            $emp_res_pincode,
            $emp_mobile_no,
            $emp_email_id,
            $emp_username
        ));
        
        if ($result) {
            echo '<script>window.alert("Your Profile is Successfully Updated !!!"); window.location.href="../employee/emp_view_'.$part.'.php";</script>';
        } else {
            echo "Error: " . pg_last_error($conn);
        }
    } else if ($part === 'profile') {
        $update_more = "UPDATE employee SET 
                emp_qual = $1,
                emp_gender = $2,
                emp_date_of_birth = $3,
                emp_name = $4
                WHERE username = $5";

        $stmt = pg_prepare($conn, "update_query", $update_more);

        $result = pg_execute($conn, "update_query", array(
            $emp_qual,
            $emp_gender,
            $emp_date_of_birth,
            $emp_name,
            $emp_username
        ));
        
        if ($result) {
            echo '<script>window.alert("Your Profile is Successfully Updated !!!"); window.location.href="../employee/emp_view_'.$part.'.php";</script>';
        } else {
            echo "Error: " . pg_last_error($conn);
        }
    }
    
} else {
    session_start();
    $ad_username = $_SESSION["admin_username"] ?? '';
    
    include '../!admin_username.php';


    // Begin transaction
    pg_query($conn, "BEGIN");

    $counter_query = "SELECT counter FROM emp_username_generator ORDER BY emp_id DESC LIMIT 1";
    $counter_result = pg_query($conn, $counter_query);

    if ($counter_result) {
        $row = pg_fetch_assoc($counter_result);
        $counter = $row['counter'];

        $newCounter = $counter + 1;
        $updateCounter = "INSERT INTO emp_username_generator (counter) VALUES ($newCounter)";
        $newResult = pg_query($conn, $updateCounter);

        if (!$newResult) {
            pg_query($conn, "ROLLBACK"); // Rollback the transaction if updateCounter fails
            die("Error updating counter: " . pg_last_error($conn));
        }

        $emp_username = 'EMP' . $counter;

        $emp_hashed_password = password_hash($emp_password, PASSWORD_DEFAULT);
        $status = 'Active';
        $emp_reg_query = "INSERT INTO employee (emp_name, emp_res_address, emp_res_state, emp_res_district, emp_res_pincode, emp_date_of_birth, emp_mobile_no, emp_email_id, emp_gender, emp_qual, emp_date_of_joining, emp_gov_id, emp_id, emp_des, username, password, status) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17)";
        $emp_reg_params = array($emp_name, $emp_res_address, $emp_res_state, $emp_res_district, $emp_res_pincode, $emp_date_of_birth, $emp_mobile_no, $emp_email_id, $emp_gender, $emp_qual, $emp_date_of_joining, $emp_gov_id, $emp_id, $emp_des, $emp_username, $emp_hashed_password, $status);
        $emp_reg_execute = pg_query_params($conn, $emp_reg_query, $emp_reg_params);

        if ($emp_reg_execute) {
            pg_query($conn, "COMMIT"); // Commit the transaction if everything is successful
            echo '<script>window.alert("Employee has been added Successfully with username = '.$emp_username.'!!!"); window.location.href="../admin/ad_emp_options.php";</script>';
        } else {
            pg_query($conn, "ROLLBACK"); // Rollback the transaction if emp_reg_execute fails
            $rev_query = "DELETE FROM emp_username_generator WHERE counter = $newCounter";
            $rev_execute = pg_query($conn, $rev_query);
            echo '<script>window.alert("Got some technical Failure!!!"); window.location.href="../admin/emp_reg.php";</script>';
            echo "Error: " . pg_last_error($conn);
        }
    } else {
        die("Error fetching counter: " . pg_last_error($conn));
    }
}

pg_close($conn);
?>
