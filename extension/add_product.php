<?php
require_once '../includes/db.php';
if (isset($_POST['add_item'])) {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $min_order = $_POST['min_order'];
    $product_details = $_POST['productDetails'];
    $user_id = $_SESSION['user_id'];
    $cat = $_POST['category'];

    $upload_dir = '../images/'; // Specify the directory where you want to save uploaded images
    $image_name = $_FILES['product_image']['name'];
    $image_path = $upload_dir . $image_name;

    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $image_path)) {
        $insert_query = "INSERT INTO products (product_name, product_price, product_cat, product_stock, min_order, product_img, seller_id, product_details)
            VALUES ('$product_name', '$price', '$cat', '$stock', '$min_order', '$image_name', '$user_id', '$product_details')";

        if ($conn->query($insert_query) === TRUE) {
            echo "Product added successfully!";
            header("location: ../inventory.php");
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    } else {
        echo "Image upload failed.";
    }
}

$conn->close();
?>
