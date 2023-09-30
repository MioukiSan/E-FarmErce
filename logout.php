<?php
    require_once './includes/db.php';
    session_destroy();
    header("location: ./");
?>