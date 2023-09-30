<?php 
require_once '../includes/db.php';

$user_id = $_POST['user_id'];
$product_id = $_POST['product_id'];
$qty = $_POST['quantity'];
$selectedProducts = $_POST['selected_products'];

$sql = "SELECT min_order, product_stock FROM products WHERE product_id = '$product_id'";
$result = mysqli_query($conn, $sql);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $min_order = $row['min_order'];
    $product_stock = $row['product_stock'];

    if ($min_order > $qty) {
        $new_qty = $min_order;
    } elseif ($qty > $product_stock) {
        $new_qty = $product_stock;
    } else {
        $new_qty = $qty;
    }

    // SQL query to update the cart with the new quantity
    $update_sql = "UPDATE cart SET order_qty = $new_qty WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $update_result = mysqli_query($conn, $update_sql);

    if ($update_result) {

    } else {
        echo "Cart update failed.";
    }
} else {
    echo "Product information not found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../checkout.php" method="post" id="updateForm">
    <?php 
    foreach($selectedProducts as $ids){
    ?>
        <input type="hidden" name="selected_products[]" value="<?php echo $ids ?>">
    <?php } ?>
    </form>
    <script>
        document.getElementById('updateForm').submit();
    </script>
</body>
</html>
