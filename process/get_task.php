<?php
    session_start();
    if(isset($_GET['title'])){
        $_SESSION['title'] = $_GET['title'];
        $_SESSION['get_back'] = TRUE;
    }
    echo "<script>window.location.href='list_tickets.php'</script>";
?>