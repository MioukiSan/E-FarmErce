<?php
// Include your database connection code here
require_once 'db.php';

// Check if notifId is provided in the POST request
if (isset($_POST['notifId'])) {
    $notifId = $_POST['notifId'];

    // Update the notif_sts to 'Read' for the specified notification
    $updateSql = "UPDATE seller_notif SET notif_sts = 'Read' WHERE notif_seller_id = $notifId";

    if ($conn->query($updateSql) === TRUE) {
        // Send a success response if the update was successful
        echo json_encode(['success' => true, 'message' => 'Notification status updated to "Read".']);
    } else {
        // Send an error response if the update failed
        echo json_encode(['success' => false, 'message' => 'Error updating notification status: ' . $conn->error]);
    }
} else {
    // Send an error response if notifId is not provided
    echo json_encode(['success' => false, 'message' => 'Notif ID not provided in the request.']);
}
?>
