<?php
    session_start();
    $user = isset($_SESSION['username']) ? $_SESSION['username']  :'-';
    $loc = $user == '-' ? 'location: ../login.php' : 'location: home.php';
    //echo $loc;
    header($loc);
?>