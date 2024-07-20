<?php
session_start();

echo "<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <title>Authenticating ...</title>
</head>
<body>
</body>
</html>";

include '../process/connect.php';


// Validation of the Username and Password;
$emp_username = $_POST["emp_username"] ?? '';
if (!$emp_username) {
  echo '<script>window.location.href="forgot_emp.html"</script>';
  exit;
}

$emp_gov_id = $_POST["emp_gov_id"] ?? '';
$emp_id = $_POST["emp_id"] ?? '';

// Validate the username and retrieve security question and answer
$validate_username_query = "SELECT username, emp_gov_id, emp_id FROM employee WHERE username = $1";
$result = pg_query_params($conn, $validate_username_query, array($emp_username));

if ($result && pg_num_rows($result) > 0) {
  $row = pg_fetch_assoc($result);
  $emp_gov_id_db = $row['emp_gov_id'];

  if ($emp_gov_id == $emp_gov_id_db) {
    $emp_id_db = $row['emp_id'];
    // Verify the security answer
    if ($emp_id == $emp_id_db) {
      $_SESSION["reset_emp_username"] = $emp_username;
      echo '<script>window.alert("Validated Successfully !!!"); window.location.href="reset_emp.php"</script>';
    } else {
      echo '<script>window.alert("You have entered wrong Government Id Number!!!"); window.location.href="forgot_emp.html"</script>'; 
    }
  } else {
    echo '<script>window.alert("Government Id not matched with the submitted Id !!!"); window.location.href="forgot_emp.html"</script>';
  }
} else {
  echo '<script>window.alert("Entered username not found !!!"); window.location.href="index.html";</script>';
}

pg_close($conn);
?>
