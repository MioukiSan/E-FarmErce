<?php
require_once '../includes/db.php';

$user_id = $_POST['user_id'];
$product_id = $_POST['product_id'];
$sellerIdQuery = "SELECT seller_id FROM products WHERE product_id = '$product_id'";
$sellerIdResult = mysqli_query($conn, $sellerIdQuery);
while($seller = mysqli_fetch_assoc($sellerIdResult)){
    $id = $seller['seller_id'];
}

$t = $_POST['transact'];
$array = [];
$array2 = [];

$selectedProducts = $_POST['selected_products'];
foreach ($selectedProducts as $rw) {
    $query = "SELECT product_id FROM cart WHERE cart_id = '$rw'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $product = mysqli_fetch_assoc($result);
        $array[] = $product['product_id'];
    } 
}

foreach ($array as $r) {
    $query1 = "SELECT product_id FROM products WHERE seller_id = '$id' AND product_id = '$r'";
    $result1 = mysqli_query($conn, $query1);

    if ($result1) {
        $product1 = mysqli_fetch_assoc($result1);
        
        // Check if the product_id is not zero before adding to array2
        if ($product1['product_id'] != 0) {
            $array2[] = $product1['product_id'];
        }
    } else {
        echo "Error fetching product data for product_id: $r";
    }
}

if (!empty($array2)) {
    $product_ids = implode(',', $array2); // Convert the array of product IDs to a comma-separated string
    $update_sql = "UPDATE cart SET selected_mode = '$t' WHERE user_id = '$user_id' AND product_id IN ($product_ids)";
    $update_result = mysqli_query($conn, $update_sql);

    if (!$update_result) {
        echo "Cart update failed.";
    }
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
