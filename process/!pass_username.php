<?php
$query = "SELECT * FROM passenger WHERE username = $1;";
$pass_array = array($pass_username);
$result = pg_query_params($conn,$query,$pass_array);
if (pg_num_rows($result) == 0) {
    echo '<script>window.location.href="../passenger/index.html";</script>';
    exit();
}
?>
