<?php
session_start();

$train_no = $_SESSION['train_no'];
$doj = $_SESSION['doj'];
$endStn = $_SESSION['endStn'];
$startStn = $_SESSION['startStn'];
$userType = $_SESSION['userType'];

if ($userType === "passenger") {
    $user = "Passengers";
} elseif ($userType === "travel_agent") {
    $user = "Travel Agents";
} elseif ($userType === "employee") {
    $user = "Employees";
}

$username = $_SESSION['username'];

if (!$username) {
    echo "<script>window.location.href='../index.html'</script>";
    exit;
}

include 'connect.php';

include 'getUserStatus.php';

$getLimit = "SELECT booking_limit FROM limits WHERE user_type = $1";
$getLimitExe = pg_query_params($conn, $getLimit, array($userType));

if ($getLimitExe) {
    $getLimitRow = pg_fetch_assoc($getLimitExe);
    $booking_limit = $getLimitRow['booking_limit'];

    $today_date = new DateTime();
    $doj_date = new DateTime($doj);

    $interval = $today_date->diff($doj_date);
    $currLimit = $interval->days;

    if ($currLimit > $booking_limit) {
        session_destroy();
        echo '<script>window.alert("For ' . $user . ', Advance Booking Limit is Allowed for Only ' . $booking_limit . ' Days in Advance !!! Please Select Date of Journey Accordingly ..."); window.location.href="../index.html";</script>';
        exit;
    } else {
        $get_train_name = "SELECT train_name FROM trains WHERE train_no = $1";
        $get_train_execute = pg_query_params($conn, $get_train_name, array($train_no));
        if ($get_train_execute) {
            $train_row = pg_fetch_assoc($get_train_execute);
            $train_name = $train_row['train_name'];
        }

        $get_stn_name = "SELECT station_name FROM stations WHERE station_code = $1";

        $get_start_execute = pg_query_params($conn, $get_stn_name, array($startStn));
        if ($get_start_execute) {
            $start_row = pg_fetch_assoc($get_start_execute);
            $start_name = $start_row['station_name'];
        } else {
            echo 'Error: 1';
            exit;
        }

        $get_end_execute = pg_query_params($conn, $get_stn_name, array($endStn));
        if ($get_end_execute) {
            $end_row = pg_fetch_assoc($get_end_execute);
            $end_name = $end_row['station_name'];
        } else {
            echo 'Error: 2';
            exit;
        }

        if ($userType === 'passenger' || $userType === 'employee') {
            $get_user_info = "SELECT * FROM $userType WHERE username = $1";
            $get_user_execute = pg_query_params($conn, $get_user_info, array($username));
            if ($get_user_execute) {
                $user_row = pg_fetch_assoc($get_user_execute);
                if ($userType === 'passenger') {
                    $user_name = $user_row['name'];
                    $user_gender = $user_row['gender'];
                    $user_email = $user_row['email_id'];
                    $user_mob = $user_row['mobile_no'];

                    // Function to get passenger age in years
                    function get_passenger_age($conn, $pass_username) {
                        $query = "
                            SELECT EXTRACT(YEAR FROM AGE(date_of_birth)) AS age_in_years
                            FROM passenger
                            WHERE username = $1
                        ";
                        $result = pg_query_params($conn, $query, array($pass_username));
                        if ($result && pg_num_rows($result) > 0) {
                            return pg_fetch_result($result, 0, 'age_in_years');
                        } else {
                            return null;
                        }
                    }

                    $pass_username = $username;
                    $user_age = get_passenger_age($conn, $pass_username);

                } else {
                    $user_name = $user_row['emp_name'];
                    $user_gender = $user_row['emp_gender'];
                    $user_email = $user_row['emp_email_id'];
                    $user_mob = $user_row['emp_mobile_no'];

                    // Function to get employee age in years
                    function get_employee_age($conn, $emp_username) {
                        $query = "
                            SELECT EXTRACT(YEAR FROM AGE(emp_date_of_birth)) AS age_in_years
                            FROM employee
                            WHERE username = $1
                        ";
                        $result = pg_query_params($conn, $query, array($emp_username));
                        if ($result && pg_num_rows($result) > 0) {
                            return pg_fetch_result($result, 0, 'age_in_years');
                        } else {
                            return null;
                        }
                    }

                    $emp_username = $username;
                    $user_age = get_employee_age($conn, $emp_username);
                }
            } else {
                echo 'Error: 3';
                exit;
            }
        } else {
            $user_gender = 'Select Gender';
        }
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../design/sign_up.css">

            <title>ADD DETAILS</title>
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
                <form id="signUpForm" action="verify_details.php" method="post" onsubmit="return validateForm()">
                    <br>
                    <div class="heading">
                        <label>Add Traveler's Details</label>
                    </div>
                    <br>
                    <footer>
                        <div class="col1">
                            <br>
                            <div class="fields1">
                                <input type="text" name="route_code" placeholder="Train Number" id="route_code" value="<?php echo $train_no; ?>" readonly required><br>
                                <div id="routeMessage"></div><br><br>
                                <input type="text" name="train_name" placeholder="From To" id="train_name" value="<?php echo $start_name .' To '.$end_name; ?>" readonly required><br>
                                <br><br>
                                <input type="text" name="traveler_name" placeholder="Enter Traveler's Name" id="traveler_name" value="<?php echo $user_name; ?>" maxlength="100" required><br>
                                <span class="error" id="SS_fareError">Please Enter only Number</span>
                                <br><br>
                                <div class="sec">
                                    <select name="user_gender" id="sec_ques" required>
                                        <option selected hidden><?php echo $user_gender; ?></option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                    <br><br>
                                    <br>
                                    <input type="text" name="mobile_no" placeholder="Enter Traveler's Mobile Number" id="p_mobile" value="<?php echo $user_mob; ?>" maxlength="10"><br>
                        <span class="error" id="mobileError">Please enter a valid 10-digit mobile number</span>

                                </div><br>
                            </div>
                        </div>
                        <div class="col2">
                            <br>
                            <div class="fields2">
                                <input type="text" name="train_no" placeholder="Train's Name" id="train_no" value="<?php echo $train_name; ?>" readonly required><br>
                                <span class="error" id="trainNoError">Please Enter only Number</span>
                                <div id="trainMessage"></div><br><br>
                                <input type="text" name="doj" placeholder="Date of Journey" id="dep" value="<?php echo $doj; ?>" onfocus="(this.type='date')" onblur="(this.type='text')" readonly required><br>
                                <span class="error" id="depError">Valid Time is required</span><br><br>
                                <input type="number" name="age" placeholder="Enter Traveler's Age" id="age" value="<?php echo $user_age; ?>" required><br>
                                <span class="error" id="AC_fareError">Please Enter only Number</span>
                                <br><br>
                                <input type="email" name="email" placeholder="Enter Traveler's Email Id" id="email" value="<?php echo $user_email; ?>" required><br>
                            </div>
                        </div>
                    </footer>
                    <input type="text" id="do" name="do" value="ADD" hidden><br>
                    <div class="signup">
                        <input type="submit" value="ADD">
                        <button onclick="location.href = 'cancel_transaction.php'" type="button">CANCEL</button><br><br><br>
                    </div>
                </form>
            </div>
            <script src="../script/pass_signup.js" defer></script>

        </body>
        </html>
<?php
    }
}
?>
