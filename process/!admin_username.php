<?php
$query = "SELECT * FROM admin WHERE username = $1;";
$result = pg_query_params($conn,$query,$ad_username);
if (pg_num_rows($ad_username) == 0) {
    echo '<script>window.location.href="index.html";</script>';
    exit();
}
?>
