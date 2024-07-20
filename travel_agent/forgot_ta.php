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
$ta_username = $_POST["ta_username"] ?? '';
if (!$ta_username) {
  echo '<script>window.location.href="forgot_ta.html"</script>';
  exit;
}

$ta_gov_id = $_POST["ta_gov_id"] ?? '';
$ta_id = $_POST["ta_id"] ?? '';

// Validate the username and retrieve security question and answer
$validate_username_query = "SELECT username, ta_gov_id, ta_id FROM travel_agent WHERE username = $1";
$result = pg_query_params($conn, $validate_username_query, array($ta_username));

if ($result && pg_num_rows($result) > 0) {
  $row = pg_fetch_assoc($result);
  $ta_gov_id_db = $row['ta_gov_id'];

  if ($ta_gov_id == $ta_gov_id_db) {
    $ta_id_db = $row['ta_id'];
    // Verify the security answer
    if ($ta_id == $ta_id_db) {
      $_SESSION["reset_ta_username"] = $ta_username;
      echo '<script>window.alert("Validated Successfully !!!"); window.location.href="reset_ta.php"</script>';
    } else {
      echo '<script>window.alert("You have entered wrong Government Id Number!!!"); window.location.href="forgot_ta.html"</script>'; 
    }
  } else {
    echo '<script>window.alert("Government Id not matched with the submitted Id !!!"); window.location.href="forgot_ta.html"</script>';
  }
} else {
  echo '<script>window.alert("Entered username not found !!!"); window.location.href="index.html";</script>';
}

pg_close($conn);
?>
