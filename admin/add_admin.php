<?php
echo "<!DOCTYPE html>
<head>
    <title>Authenticating ...</title>
</head>
<body>
</body>
</html>";

include '../process/connect.php';

$uid = 'ad_01';
$name = 'Administrator';
$ad_username = 'admin' ;
$ad_password = 'admin@123';

$ad_conn = $conn;

// Sanitize inputs if needed (not shown here, but recommended)
$ad_hashed_password = password_hash($ad_password,PASSWORD_DEFAULT);

// Query to validate the username
$add_admin = "insert into admin values($1,$2,$3,$4);";
$admin_params = array($uid,$name,$ad_username,$ad_hashed_password);
$add_admin_execute = pg_query_params($ad_conn, $add_admin, $admin_params);

if (!$add_admin_execute) {
    die("Error in SQL query: " . pg_last_error());
}
else
{
    echo "Successfully Registered";
}
// Close database connection
pg_close($ad_conn);
?>
