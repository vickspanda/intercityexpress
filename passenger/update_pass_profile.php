<?php
session_start();
$pass_username = $_SESSION["pass_username"] ?? '';

include '../process/!pass_username.php';


include '../process/connect.php';
$username = $pass_username;
$userType = 'passenger';
$_SESSION['userType'] = $userType;
include '../process/getUserStatus.php';

function get_passenger_data($conn, $pass_username, $field) {
    $query = "SELECT $field FROM passenger WHERE username = $1";
    $result = pg_query_params($conn, $query, array($pass_username));
    if ($result && pg_num_rows($result) > 0) {
        return pg_fetch_result($result, 0, 0);
    } else {
        return null;
    }
}

$pass_name = get_passenger_data($conn, $pass_username, 'name');
$pass_address = get_passenger_data($conn, $pass_username, 'address');
$pass_district = get_passenger_data($conn, $pass_username, 'district');
$pass_state = get_passenger_data($conn, $pass_username, 'state');
$pass_pincode = get_passenger_data($conn, $pass_username, 'pincode');
$pass_mobile_no = get_passenger_data($conn, $pass_username, 'mobile_no');
$pass_email_id = get_passenger_data($conn, $pass_username, 'email_id');
$pass_dob = get_passenger_data($conn, $pass_username, 'date_of_birth');
$pass_age_query = pg_query_params($conn, "SELECT AGE(date_of_birth) FROM passenger WHERE username = $1", array($pass_username));
$pass_age = pg_fetch_result($pass_age_query, 0, 0);
$pass_gender = get_passenger_data($conn, $pass_username, 'gender');
pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/sign_up.css">
    <title>Update Account</title>
    <style>
        .error {
            color: white;
            display: none;
        }
        .invalid {
            border-color: red;
        }
    </style>
    <script src="../script/pass_update.js" defer></script>
</head>
<body>
    <div class="bg-image"></div>
    <div class="create_account">
        <form id="signUpForm" action="sign_up.php?part=update" method="post">
            <br>
            <div class="heading">
                <label>Update Profile</label>
            </div>
            <br>
            <footer>
                <div class="col1">
                    <div class="fields1">
                        <input type="text" name="p_name" placeholder="Full Name" id="p_name" value="<?php echo $pass_name;?>" autofocus required><br>
                        <span class="error" id="nameError">Name should be less than 60 characters</span><br><br>
                        <input type="text" name="p_address" placeholder="Address" value="<?php echo $pass_address;?>" id="p_address" required><br>
                        <span class="error" id="addressError">Address should be less than 500 characters</span><br><br>
                    </div>
                    <div class="drop_down">
                        <select id="state" name="p_state" class="state" required onchange="populateDistricts()">
                            <option selected hidden><?php echo $pass_state;?></option>
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
                        <select id="district" name="p_district" class="district" required>
                            <option value="<?php echo $pass_district;?>" selected hidden><?php echo $pass_district;?></option>
                        </select>
                    </div><br><br>
                    <div class="fields2">
                        <input type="text" name="p_pincode" placeholder="Pin Code" id="p_pincode" value="<?php echo $pass_pincode;?>" required><br>
                        <span class="error" id="pincodeError">Please enter a valid 6-digit Pin Code</span><br><br>
                        <div class="DOB">
                            <input type="text" name="p_dob" placeholder="Date of Birth" id="p_dob" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo $pass_dob;?>" required><br>
                            <span class="error" id="dobError">Date of Birth is required</span><br><br>
                        </div>
                    </div>
                </div>
                <div class="col2">
                    <div class="sec">
                        <select name="p_gender" id="sec_ques" required>
                            <option selected hidden><?php echo $pass_gender;?></option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div><br><br>
                    <div class="fields2">
                        <input type="text" name="p_mobile" placeholder="Mobile Number" id="p_mobile" value="<?php echo $pass_mobile_no;?>" required><br>
                        <span class="error" id="mobileError">Please enter a valid 10-digit mobile number</span><br><br>
                        <input type="email" name="p_email" placeholder="Email Id" id="p_email" value="<?php echo $pass_email_id;?>" required><br>
                        <span class="error" id="emailError">Valid Email is required</span><br><br>
                    </div>
                    <div class="fields1">
                        <input type="text" name="p_username" placeholder="<?php echo $pass_username;?>" id="p_username" readonly><br>
                        <span class="error" id="usernameError">Username should be less than 30 characters</span><div id="usernameMessage"></div><br><br>
                    </div>
                </div>
            </footer>
            <div class="signup">
                <input type="submit" value="Update">
                <button onclick="location.href = 'passenger_view_profile.php'" type="button">Cancel</button><br><br><br>
            </div>
        </form>
    </div>
</body>
</html>
