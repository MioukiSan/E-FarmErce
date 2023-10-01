<?php 
require_once '../includes/db.php';
$user_id = $_SESSION['user_id'];

if(isset($_POST['readAll'])){
    $updateSql = "UPDATE notifications SET mess_status = 'Read' WHERE seller_id = '$user_id'";

    if ($conn->query($updateSql) === TRUE) {
        echo '<script>window.location.href = document.referrer;</script>';
    } else {
        echo "Error updating notifications: " . $conn->error;
    }
}
?>
