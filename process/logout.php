<?php
    session_start();
    echo "<html><head><title>Logging Out</title></head><html>";
    $user = $_GET["user"];
    session_destroy();
    session_abort();
    echo '<script>window.location.href="'.$user.'index.html"</script>';
?>
