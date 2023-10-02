<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $output = array(); 

    $sql = "SELECT DISTINCT u.fullname, u.user_id AS user_id
            FROM (
                SELECT incoming_msg_id AS user_id FROM messages WHERE outgoing_msg_id = ?
                UNION
                SELECT outgoing_msg_id AS user_id FROM messages WHERE incoming_msg_id = ?
            ) AS combined_users
            JOIN users u ON combined_users.user_id = u.user_id";
    
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ii', $userId, $userId);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            while ($row = mysqli_fetch_assoc($result)) {
                $fullname = $row['fullname'];
                
                $output[] = array(
                    'user_id' => $row['user_id'],
                    'fullname' => $fullname
                );
            }
            
            echo json_encode($output);
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
