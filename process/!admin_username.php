<?php
$query = "SELECT * FROM admin WHERE username = $1;";
$admin_array = array($ad_username);
$result = pg_query_params($conn,$query,$admin_array);
if (pg_num_rows($ad_username) == 0) {
    echo '<script>window.location.href="index.html";</script>';
    exit();
}
?>
