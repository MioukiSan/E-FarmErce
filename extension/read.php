<?php 
require_once '../includes/db.php';
$user_id = $_SESSION['user_id'];

if(isset($_POST['readAll'])){
    $updateSql = "UPDATE seller_notif SET notif_sts = 'Read' WHERE seller_id = '$user_id'";

    if ($conn->query($updateSql) === TRUE) {
        echo '<script>window.location.href = document.referrer;</script>';
    } else {
        echo "Error updating notifications: " . $conn->error;
    }
}
?>
