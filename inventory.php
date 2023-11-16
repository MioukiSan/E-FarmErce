<?php 
    require_once './includes/db.php';

    if (isset($_POST['delete_item'])) {
        $product_id = $_POST['product_id'];
        
        $deleteQuery = "UPDATE products SET product_status = 'Deleted' WHERE product_id = $product_id";
        
        $updateResult = mysqli_query($conn, $deleteQuery);
        
        if ($updateResult) {
           header("location: inventory.php?successfully deleted");
        } else {
           
        }
    }
    if (isset($_POST['edit_item'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $min_order = $_POST['min_order'];
        $mode_available = $_POST['mode_available'];
        $delivery_location = $_POST['delivery_location'];
        $pickup_address = $_POST['pickup_address'];
        $product_details = $_POST['productDetails'];
        $product_status = $_POST['status']; 
        $user_id = $_POST['user_id'];
    
            $update_query = "UPDATE products SET 
            product_name = '$product_name',
            product_price = '$price',
            product_stock = '$stock',
            min_order = '$min_order',
            product_details = '$product_details',
            product_status = '$product_status'
            WHERE product_id = '$product_id'";
    
        if ($conn->query($update_query) === TRUE) {
            if ($conn->affected_rows > 0) {
                echo "Product updated successfully!";
            } else {
                echo "No changes made to the product.";
            }
            header("location: inventory.php");
        } else {
            echo "Error: " . $update_query . "<br>" . $conn->error;
        }
    }    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <?php require_once './includes/head.php'; ?>
</head>
<body class="pad">
    <div class="container">
        <?php require_once './includes/sidenav.php';?>
        <div class="row">
            <div class="col-11">
                <h1 style="padding-top: 10px;">INVENTORY</h1>
            </div>
            <div class="col-1 d-flex float-end">
                <?php require_once './extension/notif_seller.php';?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex">
                <div class="col-md-11">
                    <form class="d-flex mt-3" action="?query"  method="GET" role="search">
                        <input class="form-control" type="search" name="search_inv" placeholder="Search products" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="col-md-1 pt-3 text-end">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#additem"><ion-icon name="add-circle-outline"></ion-icon>Product</button>
                </div>
                <div class="modal fade" id="additem" tabindex="-1" aria-labelledby="additem" aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                            <form action="./extension/add_product.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <h3 class="text-center mt-3" style="color: green;"><b><ion-icon name="add-circle-outline"></ion-icon>ADD Product</b></h3>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Product Name</span>
                                    <input type="text" class="form-control" name="product_name" placeholder="Enter product name" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Price</span>
                                    <input type="number" class="form-control" name="price" placeholder="Enter price" required>
                                    <span class="input-group-text">per kilo</span>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Stock</span>
                                    <input type="text" class="form-control" name="stock" placeholder="Enter stock quantity" required>
                                    <span class="input-group-text">KG</span>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Minimum Order</span>
                                    <input type="number" class="form-control" name="min_order" placeholder="Enter minimum order quantity" required>
                                </div>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="category">Category</label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="fruit">Fruit</option>
                                        <option value="vegetable">Vegetable</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="productDetails">Product Details</label>
                                    <div class="input-group">
                                        <textarea class="form-control" name="productDetails" rows="3" placeholder="Enter product details(eg. when harvested.)"></textarea>
                                    </div>
                                </div>
                                <div id="img_input">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Product Image</span>
                                        <input type="file" class="form-control" name="product_image" placeholder="add image">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-success" name="add_item" type="submit">ADD ITEM</button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="table-responsive">
                <table class="table table-responsive">
                    <thead class="table-light text-center">
                        <tr>
                            <th>PRODUCT</th>
                            <th>PRODUCT DETAILS</th>
                            <th>PRODUCT STATUS</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (isset($_GET['search_inv'])) {
                                $searchQuery = $_GET['search_inv'];
                                
                                $query1 = "SELECT * FROM products WHERE seller_id = '{$_SESSION['user_id']}' 
                                           AND (product_name LIKE '%$searchQuery%' OR product_cat LIKE '%$searchQuery%') 
                                           ORDER BY product_id DESC";
                                $result1 = mysqli_query($conn, $query1);
                            } else {
                                $query1 = "SELECT * FROM products WHERE seller_id = '{$_SESSION['user_id']}' ORDER BY product_id DESC";
                                $result1 = mysqli_query($conn, $query1);
                            }
                            
                            if ($result1) :
                                while ($row = mysqli_fetch_assoc($result1)) :
                            ?>
                            <tr <?php if($row['product_status'] === 'Restricted'){ echo 'class = "table-danger"';} else { echo '';}?>>
                                <td>
                                    <div class="row">
                                        <div class="col-md-6 text-end">
                                            <img  style="width: 6em;" src="./images/<?= $row['product_img'] ?>">
                                        </div>
                                        <div class="col-md-6">
                                            Other Details: <?= $row['product_name'] ?><br>
                                            Price: <?= $row['product_price'] ?> PHP per kg<br>
                                            Stock: <?= $row['product_stock'] ?> kg<br>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <?= $row['product_details'] ?><br>
                                    Min Order: <?= $row['min_order'] ?><br>
                                </td>
                                <td class="text-center" style="color: <?php if($row['product_status'] == 'On Sale'){echo 'green';}elseif($row['product_status'] == 'Restricted'){ echo 'red';} else {echo 'blue';}?>">
                                    <?php echo $row['product_status'];?>
                                </td>
                                <td class="text-center">
                                <button type="submit" class="btn" data-bs-toggle="modal" data-bs-target="#edit_item<?php echo $row['product_id']; ?>"><ion-icon name="create-outline"></ion-icon></button>
                                    <div class="modal fade" id="edit_item<?php echo $row['product_id']; ?>" tabindex="-1" aria-labelledby="additem" aria-hidden="true" data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                                    <h3 class="text-center mt-3" style="color: green;"><b><ion-icon name="create-outline"></ion-icon>EDIT PRODUCT</b></h3>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">Product Name</span>
                                                            <input type="text" class="form-control" name="product_name" value="<?php echo $row['product_name'] ?>">
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">Price</span>
                                                            <input type="number" class="form-control" name="price" value="<?php echo $row['product_price'] ?>">
                                                            <span class="input-group-text">per kilo</span>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">Stock</span>
                                                            <input type="text" class="form-control" name="stock" value="<?php echo $row['product_stock'] ?>">
                                                            <span class="input-group-text">KG</span>
                                                        </div>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Minimum Order</span>
                                                            <input type="number" class="form-control" name="min_order" value="<?php echo $row['min_order'] ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="productDetails">Product Details</label>
                                                            <div class="input-group">
                                                                <textarea class="form-control" name="productDetails" rows="3"><?php echo $row['product_details']; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <?php if ($row['product_status'] === 'Restricted') { ?>
                                                            <div class="alert alert-danger" role="alert">
                                                                Product violated the policy.
                                                            </div>
                                                        <?php } ?>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">Product Status</span>
                                                            <select class="form-select" name="status" <?php echo ($row['product_status'] == 'restricted') ? 'disabled' : ''; ?>>
                                                                <?php if ($row['product_status'] == 'On Sale'): ?>
                                                                    <option value="On Sale" selected>On Sale</option>
                                                                    <option value="Sold">Sold</option>
                                                                <?php elseif ($row['product_status'] == 'Sold'): ?>
                                                                    <option value="Sold" selected>Sold</option>
                                                                    <option value="On Sale">On Sale</option>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                        <div class="text-center">
                                                            <button class="btn btn-outline-danger" name="delete_item" type="submit"><ion-icon name="trash-outline"></ion-icon></button>
                                                            <button class="btn btn-outline-success" name="edit_item" type="submit">EDIT ITEM</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            endwhile;
                            mysqli_free_result($result1);
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>