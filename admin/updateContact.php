<?php
    session_start();
    $ad_username = $_SESSION["admin_username"];
    include '../process/!admin_username.php';

    include '../process/connect.php';

    $getContactQuery = "SELECT * FROM contact WHERE uid = 1";
    $getContactExe = pg_query($conn, $getContactQuery);
    if($getContactExe){
        $getContactRow = pg_fetch_assoc($getContactExe);
        $mobile_no = $getContactRow['mobile_no'];
        $email_id = $getContactRow['email_id'];
        $address = $getContactRow['address'];
        $district = $getContactRow['district'];
        $state = $getContactRow['state'];
        $pincode = $getContactRow['pincode'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/updateContact.css">
    <title>Update Contact</title>
    <style>
        .error {
            color: white;
            display: none;
        }
        .invalid {
            border-color: red;
        }
    </style>
</head>
<body>
    <div class="bg-image"></div>
    <div class="create_account">
        <form id="signUpForm" action="updateContactExe.php" method="post">
            <br><br>
            <div class="heading">
                <label>Update Contact</label>
            </div>
            <br>

                <div class="col1">
                    <div class="fields1">
                        <input type="text" name="p_name" placeholder="Full Name" id="p_name" hidden><br>
                        <textarea name="p_address" placeholder="Address" id="p_address" maxlength="200" autofocus required><?php echo $address; ?></textarea><br>
                        <span class="error" id="addressError">Address should be less than 500 characters</span><br>
                    </div>
                    <div class="drop_down">
                        <select id="state" name="p_state" class="state" required>
                            <option value="<?php echo $state; ?>" selected hidden><?php echo $state; ?></option>
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
                        <select id="district" name="p_district" class="district">
                            <option value="<?php echo $district; ?>" selected hidden><?php echo $district; ?></option>
                        </select>
                    </div><br>
                    <div class="fields2">
                        <input type="text" name="p_pincode" placeholder="Pin Code" id="p_pincode" value="<?php echo $pincode; ?>" required><br>
                        <span class="error" id="pincodeError">Please enter a valid 6-digit Pin Code</span><br>
                        
                        <input type="text" name="p_mobile" placeholder="Mobile Number" id="p_mobile" value="<?php echo $mobile_no; ?>" required><br>
                        <span class="error" id="mobileError">Please enter a valid 10-digit mobile number</span><br>
                        <input type="email" name="p_email" placeholder="Email Id" id="p_email" value="<?php echo $email_id; ?>" required><br>
                        <span class="error" id="emailError">Valid Email is required</span><br>
                    </div>
                    <div class="fields1">
                        <input type="text" name="p_username" placeholder="Create Username" id="p_username" hidden>
                        <input type="password" name="p_password" placeholder="Create Password" id="p_password" hidden>
                        <input type="password" placeholder="Confirm Password" id="p_confirm_password" hidden>
                    </div>
                </div>
                <br>
            <div class="signup">
                <input type="submit" value="Update">
                <button onclick="location.href = 'ad_more.php'" type="button">Cancel</button><br><br><br>
            </div>
            <br>
        </form>
    </div>
    <script src="../script/pass_update.js"></script>
</body>
</html>
