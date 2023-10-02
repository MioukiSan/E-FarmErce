<?php
require_once '../includes/db.php';

$user_id = $_POST['user_id'];
$selectedProducts = $_POST['selected_products'];
$productIds = array();
$orderQuantities = array();
$total = 0;

// Create an associative array to store selected_mode for each product
$selectedModes = array();

foreach ($selectedProducts as $cartId) {
    $query = "SELECT product_id, order_qty, selected_mode FROM cart WHERE cart_id = '$cartId'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $productIds[] = $row['product_id'];
        $orderQuantities[$row['product_id']] = $row['order_qty'];
        
        // Store selected_mode for the product
        $selectedModes[$row['product_id']] = $row['selected_mode'];
    }
}

$distinctSellerIds = array();

foreach ($productIds as $productId) {
    $query = "SELECT DISTINCT seller_id FROM products WHERE product_id = '$productId'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $sellerId = $row['seller_id'];

        if (!in_array($sellerId, $distinctSellerIds)) {
            $distinctSellerIds[] = $sellerId;
        }
    }
}

foreach ($distinctSellerIds as $sellerId) {
    $orderRef = generateOrderReference(10);
    $sellerProductsQuery = "SELECT * FROM products WHERE seller_id = '$sellerId' AND product_id IN (" . implode(',', $productIds) . ")";
    $sellerProductsResult = mysqli_query($conn, $sellerProductsQuery);
    $sellerTotal = 0;
    $STotal = 0;

    while ($row = mysqli_fetch_assoc($sellerProductsResult)) {
        $productId = $row['product_id'];
        $order_qty = $orderQuantities[$productId];
        $subtotal = $row['product_price'] * $order_qty;

        // Get selected_mode for the product from the associative array
        $selectedMode = isset($selectedModes[$productId]) ? $selectedModes[$productId] : '';

        // Insert order data into the orders table with the selected_mode
        $insertOrderQuery = "INSERT INTO orders (user_id, seller_id, order_reference, product_id, order_qty, order_status, order_total, date_place, transact_mode)
                             VALUES ('$user_id', '$sellerId', '$orderRef', '$productId', '$order_qty', 'Pending', '$subtotal', NOW(), '$selectedMode')";

        // Execute the INSERT query
        $insertResult = mysqli_query($conn, $insertOrderQuery);

        if ($insertResult) {
            // Successfully inserted order, now subtract order_qty from product_stock
            $updateStockQuery = "UPDATE products SET product_stock = product_stock - $order_qty WHERE product_id = '$productId'";
            mysqli_query($conn, $updateStockQuery);

            $notifInfo = "Your products with transact order " . $orderRef . " have been checked out with total of " . CURRENCY . number_format($subtotal, 2) . ".";
            $insertNotifQuery = "INSERT INTO seller_notif (seller_id, not_info, transact_code, product_id)
                         VALUES ('$sellerId', '$notifInfo', '$orderRef', $productId)";
            mysqli_query($conn, $insertNotifQuery);
        } else {
            echo "Error inserting order data.";
        }
    }
}

// Delete the selected products from the cart
$deleteCartQuery = "DELETE FROM cart WHERE cart_id IN (" . implode(',', $selectedProducts) . ")";
$deleteCartResult = mysqli_query($conn, $deleteCartQuery);

if ($deleteCartResult) {
    // Redirect to products.php with a success message
    header("Location: ../products.php?checkout_success=1");
    exit;
} else {
    echo "Error deleting cart items.";
}
?>
