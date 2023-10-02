<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $sellerId = $_POST['sellerId'];
    $userId = $_POST['userId'];

    $sql = "INSERT INTO messages (msg, incoming_msg_id, outgoing_msg_id) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sii', $message, $sellerId, $userId);

        if (mysqli_stmt_execute($stmt)) {
            echo "Message sent successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>