<?php 
require_once '../includes/db.php';

if(isset($_POST['rate'])){
    $transact = $_POST['transact'];
    $id = $_POST['seller'];
    $rate = $_POST['rating'];
    $comm = $_POST['comment'];

    $sql = "SELECT order_id FROM orders WHERE order_reference = ? AND seller_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $transact, $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    while($row = mysqli_fetch_assoc($result)){
        $order_id = $row['order_id'];

        // Use prepared statement to update existing rows
        $updateOrderQuery = "UPDATE orders SET order_rating = ?, order_comm = ?, order_status = 'Confirmed' WHERE order_id = ?";
        $updateStmt = mysqli_prepare($conn, $updateOrderQuery);
        mysqli_stmt_bind_param($updateStmt, "isi", $rate, $comm, $order_id);
        mysqli_stmt_execute($updateStmt);
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
