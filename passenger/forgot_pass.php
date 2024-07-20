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
$pass_username = $_POST["pass_username"] ?? '';
if (!$pass_username) {
  echo '<script>window.location.href="forgot_pass.html"</script>';
  exit;
}

$pass_secq = $_POST["pass_secq"] ?? '';
$pass_seca = $_POST["pass_seca"] ?? '';

// Validate the username and retrieve security question and answer
$validate_username_query = "SELECT username, sec_ques, sec_ans FROM passenger WHERE username = $1";
$result = pg_query_params($conn, $validate_username_query, array($pass_username));

if ($result && pg_num_rows($result) > 0) {
  $row = pg_fetch_assoc($result);
  $pass_secq_db = $row['sec_ques'];

  if (password_verify($pass_secq, $pass_secq_db)) {
    $pass_seca_db = $row['sec_ans'];
    // Verify the security answer
    if (password_verify($pass_seca, $pass_seca_db)) {
      $_SESSION["reset_username"] = $pass_username;
      echo '<script>window.alert("Validated Successfully !!!"); window.location.href="reset_pass.php"</script>';
    } else {
      echo '<script>window.alert("You have entered wrong security answer !!!"); window.location.href="forgot_pass.html"</script>'; 
    }
  } else {
    echo '<script>window.alert("Security Question not matched with the given username !!!"); window.location.href="forgot_pass.html"</script>';
  }
} else {
  echo '<script>window.alert("Entered username not found !!!"); window.location.href="index.html";</script>';
}

pg_close($conn);
?>
