<?php
require_once '../includes/db.php';

if (isset($_POST['addcart'])) {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];

    // Check if the same combination already exists in the cart
    $check_sql = "SELECT c.cart_id, c.order_qty, p.product_stock, p.seller_id
                  FROM cart c
                  INNER JOIN products p ON c.product_id = p.product_id
                  WHERE c.user_id = $user_id AND c.product_id = $product_id";

    $check_result = $conn->query($check_sql);

    if ($check_result) {
        if ($check_result->num_rows > 0) {

            $cart_item = $check_result->fetch_assoc();
            $current_qty = $cart_item['order_qty'];
            $product_stock = $cart_item['product_stock'];
            $seller_id = $cart_item['seller_id']; // Retrieve seller_id from products table

            $new_qty = $current_qty + $qty;

            // Check if the new quantity exceeds the product_stock
            if ($new_qty > $product_stock) {
                $new_qty = $product_stock; // Set to product_stock if exceeded
            }

            // Update the quantity in the cart
            $update_sql = "UPDATE cart SET order_qty = $new_qty WHERE cart_id = {$cart_item['cart_id']}";

            if ($conn->query($update_sql) === TRUE) {
                // Insert a notification into the seller_notif table
                $notif_info = "Your product with product ID $product_id  changed the quanity in the cart by user $user_id.";

                $insert_notif_sql = "INSERT INTO seller_notif (seller_id, product_id, not_info)
                                     VALUES ($seller_id, $product_id, '$notif_info')";

                if ($conn->query($insert_notif_sql) === TRUE) {
                    echo "<script>alert('Item quantity updated in cart and notification sent to seller!'); window.location.href = document.referrer;</script>";
                    exit;
                } else {
                    echo "Error inserting notification: " . $conn->error;
                }
            } else {
                echo "Error updating quantity: " . $conn->error;
            }
        } else {
            // The item doesn't exist in the cart, add it as a new item
            $insert_sql = "INSERT INTO cart (user_id, product_id, order_qty) 
                           VALUES ($user_id, $product_id, $qty)";

            if ($conn->query($insert_sql) === TRUE) {
                // Retrieve seller_id from products table
                $seller_id_sql = "SELECT seller_id FROM products WHERE product_id = $product_id";
                $seller_id_result = $conn->query($seller_id_sql);
                if ($seller_id_result && $seller_id_result->num_rows > 0) {
                    $seller_id_row = $seller_id_result->fetch_assoc();
                    $seller_id = $seller_id_row['seller_id'];

                    // Insert a notification into the seller_notif table
                    $notif_info = "Your product with product ID $product_id added to cart  user $user_id.";

                    $insert_notif_sql = "INSERT INTO seller_notif (seller_id, product_id, not_info)
                                         VALUES ($seller_id, $product_id, '$notif_info')";

                    if ($conn->query($insert_notif_sql) === TRUE) {
                        echo "<script>alert('Item added to cart and notification sent to seller!'); window.location.href = document.referrer;</script>";
                        exit;
                    } else {
                        echo "Error inserting notification: " . $conn->error;
                    }
                } else {
                    echo "Error retrieving seller_id: " . $conn->error;
                }
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
