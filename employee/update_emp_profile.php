<?php
    session_start();
    $emp_username = $_SESSION["emp_username"];
    include '../process/!emp_username';

    include '../process/connect.php';
    $username = $emp_username;
    $userType = 'employee';
    $_SESSION['userType'] = $userType;
    include '../process/getUserStatus.php';


    $wtdm = $wtdp = $dism = $disp = $reqp = $reqm = '';

if(isset($_GET["part"]))
{
    $part = $_GET["part"];
    if($part === 'profile'){
        $wtdm = 'readonly';
        $dism = 'disabled';
        $reqp = 'required';
    }else if($part === 'more')
    {
        $wtdp = 'readonly';
        $disp = 'disabled';
        $reqm = 'required';
    }
}

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
$emp_mobile_no = get_employee_data($conn, $emp_username, 'emp_mobile_no');
$emp_email_id = get_employee_data($conn, $emp_username, 'emp_email_id');
$emp_res_address = get_employee_data($conn, $emp_username, 'emp_res_address');
$emp_res_state = get_employee_data($conn, $emp_username, 'emp_res_state');
$emp_res_district = get_employee_data($conn, $emp_username, 'emp_res_district');
$emp_res_pincode = get_employee_data($conn, $emp_username, 'emp_res_pincode');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/emp_reg.css">
    <title>Update Account</title>
    <style>
        .error {
            color: white;
            font-size: 15px;
        }
        .error-border {
            border-color: red;
        }
    </style>
    <script src="../script/emp_update.js" defer></script>


</head>
<body>
    <div class="bg-image"></div>
    <div class="create_account">
        <form id="employeeForm" action="../process/emp_sign_up.php?part=<?php echo $part?>" method="post">
            <br>
            <div class="heading">
                <label>Update Profile</label>
            </div>
            <br>
        <footer>
            <div class="col1">
                <div class="fields1">
                    <input type="text" id="fullName" name="fullName"<?php
                            if($part === 'more'){
                                ?>placeholder = "<?php echo $emp_name;?>"<?php
                            }   else if ($part === 'profile'){
                                ?> 
                                value = "<?php echo $emp_name;?>"
                                placeholder = "Full Name"<?php
                            }                 
                    ?> autofocus <?php echo $reqp;?> <?php echo $wtdp;?>><br>
                    <span id="fullNameError" class="error"></span><br>
                    <input type="text" id="address" name="address" <?php
                            if($part === 'profile'){
                                ?>placeholder = "<?php echo $emp_res_address;?>"<?php
                            }   else if ($part === 'more'){
                                ?> 
                                value="<?php echo $emp_res_address;?>"
                                placeholder = "Residential Address"<?php
                            }                 
                    ?>  <?php echo $reqm;?> <?php echo $wtdm;?>><br>
                    <span id="addressError" class="error"></span><br>
                </div>
                <div class="drop_down1">
                    <select id="state" name="state" class="state" <?php echo $dism;?> <?php echo $reqm;?>>
                        <option selected hidden><?php echo $emp_res_state;?></option>
                        <option>Andaman and Nicobar Islands</option>
                        <option>Andhra Pradesh</option>
                        <option>Arunachal Pradesh</option>
                        <option>Assam</option>
                        <option>Bihar</option>
                        <option>Chandigarh</option>
                        <option>Chhattisgarh</option>
                        <option>Dadra and Nagar Haveli and Daman And Diu</option>
                        <option>Delhi</option>
                        <option>Goa</option>
                        <option>Gujarat</option>
                        <option>Haryana</option>
                        <option>Himachal Pradesh</option>
                        <option>Jharkhand</option>
                        <option>Jammu and Kashmir</option>
                        <option>Ladakh</option>
                        <option>Lakshadweep</option>
                        <option>Karnataka</option>
                        <option>Kerala</option>
                        <option>Madhya Pradesh</option>
                        <option>Maharashtra</option>
                        <option>Manipur</option>
                        <option>Meghalaya</option>
                        <option>Mizoram</option>
                        <option>Nagaland</option>
                        <option>Odisha</option>
                        <option>Puducherry</option>
                        <option>Punjab</option>
                        <option>Rajasthan</option>
                        <option>Sikkim</option>
                        <option>Tamil Nadu</option>
                        <option>Telangana</option>
                        <option>Tripura</option>
                        <option>Uttarakhand</option>
                        <option>Uttar Pradesh</option>
                        <option>West Bengal</option>
                    </select>
                    <span id="stateError" class="error"></span>
                    <select id="district" name="district" class="district" <?php echo $dism;?> <?php echo $reqm;?>>
                        <option selected hidden><?php echo $emp_res_district;?></option>
                    </select>
                    <span id="districtError" class="error"></span> <br><br>
                    
                </div>
                <div class="fields2">
                <input type="text" id="pinCode" name="pinCode" <?php
                            if($part === 'profile'){
                                ?>placeholder = "<?php echo $emp_res_pincode;?>"<?php
                            }   else if ($part === 'more'){
                                ?> 
                                value="<?php echo $emp_res_pincode;?>"
                                placeholder = "Pin Code"<?php
                            }                 
                    ?> <?php echo $wtdm;?> <?php echo $reqm;?>><br>
                <span id="pinCodeError" class="error"></span><br>
                    <div class="DOB">
                        <input type="text" id="dob" name="dob" <?php
                            if($part === 'more'){
                                ?>placeholder = "<?php echo $emp_dob;?>" <?php
                            }   else if ($part === 'profile'){
                                ?> 
                                value = "<?php echo $emp_dob;?>"
                                placeholder = "Date of Birth"
                                onfocus="(this.type='Date')" onblur="(this.type='text')"<?php
                            }                 
                    ?>   <?php echo $reqp;?> <?php echo $wtdp;?>><br>
                        <span id="dobError" class="error"></span><br>
                    </div>
                    <input type="text" id="mobile" name="mobile" <?php
                            if($part === 'profile'){
                                ?>placeholder = "<?php echo $emp_mobile_no;?>"<?php
                            }   else if ($part === 'more'){
                                ?> 
                                value = "<?php echo $emp_mobile_no;?>"
                                placeholder = "Mobile Number"<?php
                            }                 
                    ?>  <?php echo $reqm;?><?php echo $wtdm;?>><br>
                    <span id="mobileError" class="error"></span><br>
                </div>

                <div class="fields1">
                <select id="gender" name="gender" class="qual" <?php echo $disp;?><?php echo $reqp;?>>
                            <option selected hidden><?php echo $emp_gender;?></option>
                            <option>Male</option>
                            <option>Female</option>
                        </select><br>
                </div>
            </div>
            <div class="col2">
                <div class="fields2">
                <input type="email" id="email" name="email" <?php
                            if($part === 'profile'){
                                ?>placeholder = "<?php echo $emp_email_id;?>"<?php
                            }   else if ($part === 'more'){
                                ?> 
                                value = "<?php echo $emp_email_id;?>"
                                placeholder = "Email Id"<?php
                            }                 
                    ?>  <?php echo $reqm;?> <?php echo $wtdm;?>><br>
                <span id="emailError" class="error"></span><br>

            </div>

                <div class="fields1">
                    <div class="DOB">
                        <select id="qualification" name="qualification" class="qual"<?php echo $disp;?> <?php echo $reqp;?>>
                            <option selected hidden><?php echo $emp_qual;?></option>
                            <option>Matriculation</option>
                            <option>Intermediate</option>
                            <option>Graduate</option>
                            <option>Post Graduate</option>
                            <option>Ph.D</option>
                        </select><br>
                        <span id="qualificationError" class="error"></span><br>
                        <input type="text" id="doj" name="doj" placeholder="<?php echo $emp_date_of_joining;?>" readonly><br>
                        <span id="dojError" class="error"></span><br>
                    </div>
                </div>
                <div class="fields1">
                    <select id="govtId" name="govtId" class="govt_id" disabled>
                        <option selected hidden><?php echo $emp_gov_id;?></option>
                        <option>Aadhar</option>
                        <option>Driving Licence</option>
                        <option>Elector Photo Identity Card</option>
                        <option>PAN</option>
                    </select><br>
                    <span id="govtIdError" class="error"></span><br>
                    <input type="text" id="idNumber" name="idNumber" placeholder="<?php echo $emp_id?>" readonly><br>
                    <span id="idNumberError" class="error"></span><br>
                    <select id="designation" name="designation" class="designation" disabled>
                        <option selected hidden><?php echo $emp_des;?></option>
                        <option>Loco-Pilot</option>
                    </select><br>
                    <span id="designationError" class="error"></span><br>
                    <input type="password" id="password" name="password" placeholder="Create Password" hidden >
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" hidden>
                    <input type="text" id="username" placeholder="<?php echo $emp_username;?>" name="username" readonly><br>
                    <br>
                </div>
            </div>
        </footer>
            <div class="signup">
                <input type="submit" value="Update">
                <button type="button" onclick="location.href = 'emp_view_<?php  echo $part; ?>.php'" >Cancel</button>
                <br><br><br>
            </div>
        </form>
    </div>

</body>
</html>
