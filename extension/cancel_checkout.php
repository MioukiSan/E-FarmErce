<?php
    require_once '../includes/db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proceed'])) {
        // Unset all session variables
        session_unset();

        // Redirect to a page after unsetting all session variables
        header('Location: ../products.php');
        exit();
    }
?>
