<?php 
require_once '../includes/db.php';

if(isset($_POST['cancel'])){
    $transact = $_POST['transact'];
    $id = $_POST['seller'];

    // Retrieve order IDs for the specified transaction and seller
    $sql = "SELECT order_id FROM orders WHERE order_reference = '$transact' AND seller_id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    while($row = mysqli_fetch_assoc($result)){
        $order_id = $row['order_id'];

        // Update order_status to 'Cancelled' for the canceled order
        $updateOrderQuery = "UPDATE orders SET order_status = 'Cancelled' WHERE order_id = '$order_id'";
        mysqli_query($conn, $updateOrderQuery);

        // Retrieve order_qty for the canceled order
        $orderQtyQuery = "SELECT product_id, order_qty FROM orders WHERE order_id = '$order_id'";
        $orderQtyResult = mysqli_query($conn, $orderQtyQuery);
        $orderQtyRow = mysqli_fetch_assoc($orderQtyResult);

        if ($orderQtyRow) {
            $product_id = $orderQtyRow['product_id'];
            $order_qty = $orderQtyRow['order_qty'];

            // Update product_stock in the products table
            $updateStockQuery = "UPDATE products SET product_stock = product_stock + $order_qty WHERE product_id = '$product_id'";
            mysqli_query($conn, $updateStockQuery);
        }

        // Insert a notification for the seller
        $notifInfo = "Your products with transact order $transact have been cancelled.";
        $insertNotifQuery = "INSERT INTO seller_notif (seller_id, not_info, transact_code, product_id)
                             VALUES ('$id', '$notifInfo', '$transact', '$product_id')";
        mysqli_query($conn, $insertNotifQuery);
    }

    // Redirect the user to the previous page they accessed
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit(); // Ensure that script execution stops after redirection
}
?>
