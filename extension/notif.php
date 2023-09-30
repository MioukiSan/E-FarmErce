<?php
require_once '../includes/db.php';

// Check if 'id' and 'transact' parameters are provided via POST
if (isset($_POST['id']) && isset($_POST['transact'])) {
    $id = $_POST['id'];
    $code = $_POST['transact'];

    // Update the notification status
    $query = "UPDATE notifications SET mess_status = 'Read' WHERE notif_id = '$id'";
    
    // Execute the SQL query
    $result = mysqli_query($conn, $query);

    if ($result) {
        // The update was successful
        echo "Notification status updated successfully.";
    } else {
        // The update failed
        echo "Error updating notification status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid parameters provided.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Update</title>
</head>
<body>
    <form action="../order_list.php" method="GET" id="updateForm">
        <input type="hidden" name="trancode" value="<?php echo $code ?>">
    </form>
    <script>
        document.getElementById('updateForm').submit();
    </script>
</body>
</html>
