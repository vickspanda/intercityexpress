<?php
    session_start();
    $ad_username = $_SESSION["admin_username"];
    include '../process/!admin_username.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/emp_reg.css">
    <title>Employee Admission</title>
    <style>
        .error {
            color: white;
            font-size: 15px;
        }
        .error-border {
            border-color: red;
        }
    </style>
    <script src="../script/emp_signup.js" defer></script>

</head>
<body>
    <div class="bg-image"></div>
    <div class="create_account">
        <form id="employeeForm" action="../process/emp_sign_up.php" method="post">
            <br>
            <div class="heading">
                <label>Employee Admission</label>
            </div>
            <br>
        <footer>
            <div class="col1">
                <div class="fields1">
                    <input type="text" id="fullName" name="fullName" placeholder="Full Name" autofocus required><br>
                    <span id="fullNameError" class="error"></span><br>
                    <input type="text" id="address" name="address" placeholder="Residential Address" required><br>
                    <span id="addressError" class="error"></span><br>
                </div>
                <div class="drop_down">
                    <select id="state" name="state" class="state" required>
                        <option value="" disabled selected hidden>Select State</option>
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
                    <select id="district" name="district" class="district" required>
                        <option value="" disabled selected hidden>Select District</option>
                    </select>
                    <span id="districtError" class="error"></span> 
                    <input type="text" id="pinCode" name="pinCode" placeholder="Pin Code" required><br>
                    <span id="pinCodeError" class="error"></span><br>
                </div>
                <div class="fields2">
                    <div class="DOB">
                        <input type="text" id="dob" name="dob" placeholder="Date of Birth" onfocus="(this.type='Date')" onblur="(this.type='text')"><br>
                        <span id="dobError" class="error"></span><br>
                    </div>
                    <input type="text" id="mobile" name="mobile" placeholder="Mobile Number"><br>
                    <span id="mobileError" class="error"></span><br>
                    <input type="email" id="email" name="email" placeholder="Email Id" required><br>
                    <span id="emailError" class="error"></span><br>
                </div>

                <div class="fields3">
                    <input type="radio" value="Male" name="gender" id="male" required>
                    <label for="male">Male</label>
                    <input type="radio" value="Female" name="gender" id="female" required>
                    <label for="female">Female</label>
                    <span id="genderError" class="error"></span><br>
                </div>
            </div>
            <div class="col2">
                <div class="fields1">
                    <div class="DOB">
                        <select id="qualification" name="qualification" class="qual" required>
                            <option value="" disabled selected hidden>Qualification</option>
                            <option>Matriculation</option>
                            <option>Intermediate</option>
                            <option>Graduate</option>
                            <option>Post Graduate</option>
                            <option>Ph.D</option>
                        </select><br>
                        <span id="qualificationError" class="error"></span><br>
                        <input type="text" id="doj" name="doj" placeholder="Date of Joining" onfocus="(this.type='Date')" onblur="(this.type='text')"><br>
                        <span id="dojError" class="error"></span><br>
                    </div>
                </div>
                <div class="fields1">
                    <select id="govtId" name="govtId" class="govt_id" required>
                        <option value="" disabled selected hidden>Select Government ID</option>
                        <option>Aadhar</option>
                        <option>Driving Licence</option>
                        <option>Elector Photo Identity Card</option>
                        <option>PAN</option>
                    </select><br>
                    <span id="govtIdError" class="error"></span><br>
                    <input type="text" id="idNumber" name="idNumber" placeholder="ID Number" required><br>
                    <span id="idNumberError" class="error"></span><br>
                    <select id="designation" name="designation" class="designation" required>
                        <option value="" disabled selected hidden>Designation</option>
                        <option>Loco-Pilot</option>
                    </select><br>
                    <span id="designationError" class="error"></span><br>
                    <input type="password" id="password" name="password" placeholder="Create Password" required><br>
                    <span id="passwordError" class="error"></span><br>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required><br>
                    <span id="confirmPasswordError" class="error"></span><br>
                </div>
            </div>
        </footer>
            <div class="signup">
                <input type="submit" value="Save">
                <button type="button" onclick="location.href = 'ad_emp_options.php'" >Cancel</button>
                <br><br><br>
            </div>
        </form>
    </div>

</body>
</html>
