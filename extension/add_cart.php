<?php
require_once '../includes/db.php';

if (isset($_POST['addcart'])) {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];

    // Check if the same combination already exists in the cart
    $check_sql = "SELECT c.cart_id, c.order_qty, p.product_stock
                  FROM cart c
                  INNER JOIN products p ON c.product_id = p.product_id
                  WHERE c.user_id = $user_id AND c.product_id = $product_id";

    $check_result = $conn->query($check_sql);

    if ($check_result) {
        if ($check_result->num_rows > 0) {
            // The item already exists in the cart, update the quantity
            $cart_item = $check_result->fetch_assoc();
            $current_qty = $cart_item['order_qty'];
            $product_stock = $cart_item['product_stock'];

            // Calculate the new quantity
            $new_qty = $current_qty + $qty;

            // Check if the new quantity exceeds the product_stock
            if ($new_qty > $product_stock) {
                $new_qty = $product_stock; // Set to product_stock if exceeded
            }

            // Update the quantity in the cart
            $update_sql = "UPDATE cart SET order_qty = $new_qty WHERE cart_id = {$cart_item['cart_id']}";

            if ($conn->query($update_sql) === TRUE) {
                echo "<script>alert('Item quantity updated in cart!'); window.location.href = document.referrer;</script>";
                exit;
            } else {
                echo "Error updating quantity: " . $conn->error;
            }
        } else {
            // The item doesn't exist in the cart, add it as a new item
            $insert_sql = "INSERT INTO cart (user_id, product_id, order_qty) 
                           VALUES ($user_id, $product_id, $qty)";

            // Perform the SQL query
            if ($conn->query($insert_sql) === TRUE) {
                echo "<script>alert('Item added to cart!'); window.location.href = document.referrer;</script>";
                exit;
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
