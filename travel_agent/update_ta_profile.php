<?php
session_start();
$ta_username = $_SESSION["ta_username"] ?? '';

include '../process/!ta_username.php';


include '../process/connect.php';
$username = $ta_username;
$userType = 'travel_agent';
$_SESSION['userType'] = $userType;
include '../process/getUserStatus.php';


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


function get_ta_data($conn, $ta_username, $field) {
    $query = "SELECT $field FROM travel_agent WHERE username = $1";
    $result = pg_query_params($conn, $query, array($ta_username));
    if ($result && pg_num_rows($result) > 0) {
        return pg_fetch_result($result, 0, 0);
    } else {
        echo '<script>window.alert("User Not Found !!!"); window.location.href="ad_view_ta.php";</script>';
        exit();
    }
}

$ta_name = get_ta_data($conn, $ta_username, 'ta_name');
$ta_dob = get_ta_data($conn, $ta_username, 'ta_date_of_birth');
$ta_age_query = pg_query_params($conn, "SELECT AGE(ta_date_of_birth) FROM travel_agent WHERE username = $1", array($ta_username));
$ta_age = pg_fetch_result($ta_age_query, 0, 0);
$ta_gov_id = get_ta_data($conn, $ta_username, 'ta_gov_id');
$ta_id = get_ta_data($conn, $ta_username, 'ta_id');
$ta_gender = get_ta_data($conn, $ta_username, 'ta_gender');
$ta_status = get_ta_data($conn, $ta_username, 'status');
$ta_com_address = get_ta_data($conn, $ta_username, 'ta_com_address');
$ta_com_state = get_ta_data($conn, $ta_username, 'ta_com_state');
$ta_com_district = get_ta_data($conn, $ta_username, 'ta_com_district');
$ta_com_pincode = get_ta_data($conn, $ta_username, 'ta_com_pincode');
$ta_mobile_no = get_ta_data($conn, $ta_username, 'ta_mobile_no');
$ta_email_id = get_ta_data($conn, $ta_username, 'ta_email_id');
$ta_res_address = get_ta_data($conn, $ta_username, 'ta_res_address');
$ta_res_state = get_ta_data($conn, $ta_username, 'ta_res_state');
$ta_res_district = get_ta_data($conn, $ta_username, 'ta_res_district');
$ta_res_pincode = get_ta_data($conn, $ta_username, 'ta_res_pincode');


pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/ta_reg.css">
    <title>Update Account</title>
    <style>
        .invalid {
            border-color:white;
        }
        .error {
            color: white;
            display: none;
        }
    </style>
    <script src="../script/ta_update.js" defer></script>


</head>
<body>
    <div class="bg-image"></div>
    <div class="create_account">
        <form action="ta_sign_up.php?part=<?php echo $part?>" method="post" id="registrationForm">
            <br><br>
            <div class="heading">
                <label>Update Profile</label>
            </div>
            <br><br>
        <footer>
            <div class="col1">
                <div class="fields1">
                    <input type="text" id="fullName" name="ta_name" <?php
                            if($part === 'more'){
                                ?>placeholder = "<?php echo $ta_name;?>"<?php
                            }   else if ($part === 'profile'){
                                ?> 
                                value = "<?php echo $ta_name;?>"
                                placeholder = "Full Name"<?php
                            }                 
                    ?> <?php echo $wtdp;?> autofocus maxlength="70"><br>
                    <span id="fullNameError" class="error">Please enter a valid name (up to 60 characters).</span><br>
                    <input type="text" id="resAddress" name="ta_res_address" <?php
                            if($part === 'profile'){
                                ?>placeholder = "<?php echo $ta_res_address;?>"<?php
                            }   else if ($part === 'more'){
                                ?> 
                                value="<?php echo $ta_res_address;?>"
                                placeholder = "Residential Address"<?php
                            }                 
                    ?>   <?php echo $wtdm;?>  maxlength="500"><br>
                    <span id="resAddressError" class="error">Please enter a valid address (up to 500 characters).</span><br>
                </div>
                <div class="drop_down1">
                    <select class="state" id="resState" name="ta_res_state"  <?php echo $dism;?> <?php echo $reqm;?> onblur="resPopulateDistricts()">
                        <option selected hidden><?php echo $ta_res_state;?></option>
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
                    <select class="district" name="ta_res_district" id="resDistrict" <?php echo $dism;?> <?php echo $reqm;?>>
                        <option selected hidden><?php echo $ta_res_district;?></option>
                    </select>
    </div>
                    <br>
                    <div class="fields2">
                    <input type="text" id="resPincode" <?php
                            if($part === 'profile'){
                                ?>placeholder="<?php echo $ta_res_pincode;?>"<?php
                            }   else if ($part === 'more'){
                                ?> 
                                value="<?php echo $ta_res_pincode;?>"
                                placeholder="Pin Code"<?php
                            }                 
                    ?>   name="ta_res_pincode" <?php echo $wtdm;?> maxlength="6"><br>
                    <span id="resPincodeError" class="error">Please enter a valid 6-digit pin code.</span>
    </div>
                <br>
                <div class="fields2">
                    <div class="DOB">
                        <input type="text" id="dob" name="ta_date_of_birth" 
                        <?php
                            if($part === 'more'){
                                ?>placeholder = "<?php echo $ta_dob;?>"<?php
                            }   else if ($part === 'profile'){
                                ?> 
                                value="<?php echo $ta_dob;?>"
                                placeholder="Date of Birth"<?php
                            }                 
                    ?>  
                         onfocus="(this.type='date')" onblur="(this.type='text')" <?php echo $wtdp;?> ><br>
                        <span id="dobError" class="error">Please enter a valid date of birth.</span><br>
                    </div>
                    <input type="text" id="mobile" name="ta_mobile_no" 
                    <?php
                            if($part === 'profile'){
                                ?>placeholder="<?php echo $ta_mobile_no;?>"<?php
                            }   else if ($part === 'more'){
                                ?> 
                                value="<?php echo $ta_mobile_no;?>"
                                placeholder="Mobile Number"<?php
                            }                 
                    ?>  
                      <?php echo $wtdm;?> maxlength="10"><br>
                    <span id="mobileError" class="error">Please enter a valid 10-digit mobile number.</span><br>
                    </div>

                <div class="fields1">
                <select class="govt_id" name="gender" id="govtId" <?php echo $disp;?> <?php echo $reqp;?>>
                        <option selected hidden><?php echo $ta_gender;?></option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                    <br>
                </div>
            </div>
            <div class="col2">
                <div class="fields1">
                    <input type="text" name="ta_com_address" id="comAddress" 
                    
                    <?php
                            if($part === 'more'){
                                ?>placeholder="<?php echo $ta_com_address;?>"<?php
                            }   else if ($part === 'profile'){
                                ?> 
                                value="<?php echo $ta_com_address;?>"
                                placeholder="Commercial Address"<?php
                            }                 
                    ?> 
                      <?php echo $wtdp;?> maxlength="500"><br>
                    <span id="comAddressError" class="error">Please enter a valid address (up to 500 characters).</span><br>
                </div>
                <div class="drop_down1">
                    <select class="state" name="ta_com_state" required id="comState" <?php echo $disp;?> <?php echo $reqp;?> onblur="comPopulateDistricts()">
                        <option selected hidden><?php echo $ta_com_state;?></option>
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
                    <select class="district" name="ta_com_district" id="comDistrict" <?php echo $disp;?> <?php echo $reqp;?>>
                        <option selected hidden><?php echo $ta_com_district;?></option>
                    </select><br><br>
                </div>
                <div class="fields2">
                    <input type="text" id="comPincode" name="ta_com_pincode" 
                    <?php
                            if($part === 'more'){
                                ?>placeholder="<?php echo $ta_com_pincode;?>"<?php
                            }   else if ($part === 'profile'){
                                ?> 
                                value="<?php echo $ta_com_pincode;?>" 
                                placeholder="Pin Code" <?php
                            }                 
                    ?> 
                    
                     <?php echo $wtdp;?> maxlength="6"><br>
                    <span id="comPincodeError" class="error">Please enter a valid 6-digit pin code.</span><br>
                    
                    <input type="email" id="email" name="ta_email_id" 
                    <?php
                            if($part === 'profile'){
                                ?>placeholder="<?php echo $ta_email_id;?>"<?php
                            }   else if ($part === 'more'){
                                ?> 
                                value="<?php echo $ta_email_id;?>"
                                placeholder="Email Id"<?php
                            }                 
                    ?> 
                    <?php echo $wtdm;?> maxlength="60"><br>
                    <span id="emailError" class="error">Please enter a valid email address (up to 60 characters).</span>
                </div>
                <br>
                <div class="fields1">
                    <input class="govt_id" name="ta_gov_id" id="govtId" placeholder="<?php echo $ta_gov_id;?>" readonly>
                    <br>
                    <span id="govtIdError" class="error">Please select a government ID.</span><br>
                    <input type="text" id="idNumber" name="ta_id" placeholder="<?php echo $ta_id;?>" readonly maxlength="20"><br>
                    <span id="idNumberError" class="error">Please enter a valid ID number (up to 20 characters).</span><br>
                    <input type="text" id="username" placeholder="<?php echo $ta_username;?>" name="ta_username" readonly required maxlength="30"><br>
                    <span id="usernameError" class="error" name="username">Please enter a valid username (up to 30 characters).</span><div id="usernameMessage"></div><br>
                    
                </div>
            </div>
        </footer>
            <div class="signup">
                <br>    
                <input type="submit" value="Update">
                <button onclick="location.href = 'ta_view_<?php echo $part?>.php'" type="button">Cancel</button><br>
            </div>
            <br><br>
        </form>
    </div>

</body>
</html>
