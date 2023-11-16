<?php 
    require_once './includes/db.php';
    
    if(isset($_POST['restrict_product'])) {
        $productID = $_POST['pID'];
    
        // SQL query to update the product_status
        $updateSQL = "UPDATE products SET product_status = 'Restricted' WHERE product_id = $productID";
    
        if(mysqli_query($conn, $updateSQL)) {
            echo "<script>alert('Product status updated to 'restricted' successfully.');</script>";
        } else {
            echo "Error updating product status: " . mysqli_error($conn);
        }
    }
    if (isset($_POST['restrict_seller'])) {
        $sellerID = $_POST['sID'];
    
        // Update product status in products table
        $updateProductSQL = "UPDATE products SET product_status = 'Restricted' WHERE seller_id = $sellerID";

        $updateUserSQL = "UPDATE users u
                          INNER JOIN products p ON u.user_id = p.seller_id
                          SET u.sts = 'Restricted'";
    
    if(mysqli_query($conn, $updateUserSQL)) {
        echo "<script>alert('Product status and seller status updated to Restricted successfully.');</script>";
    } else {
        echo "Error updating product status: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Management</title>
    <?php require_once './includes/head.php'; ?>
    <style>
        .card-cus {
            border-radius: 0;
            background-color: #fffdfdb1;
        }
    </style>
</head>
<body class="pad">
    <div class="container">
        <?php require_once './includes/sidenav.php';?>
        <div class="row">
            <h1 style="padding-top: 10px;">Report Management</h1>
            <!-- <div class="col-3 d-inline mt-3">
                <form action="" method="POST">
                    <button type="submit" name="sort" class="btn btn-light text-success" value="fruit">FRUITS</button>
                    <button type="submit" name="sort" class="btn btn-light text-success" value="vegetable">VEGETABLE</button>
                </form>
            </div>
            <div class="col-9 mt-3">
                <form class="d-flex" action="?query"  method="GET" role="search">
                    <input class="form-control rounded-start text-success" type="search" name="searchprod" placeholder="Search products" aria-label="Search">
                    <button class="btn btn-light text-success rounded-end" type="submit">Search</button>
                </form>
            </div> -->
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="table">
                    <table class="table table-responsive table-sm">
                        <thead class="text-center table-light">
                            <tr>
                                <th>PRODUCT NAME</th>
                                <th>ORDER QTY</th>
                                <th>ORDER AMOUNT</th>
                                <th>SELLER</th>
                                <th>BUYER</th>
                                <th>RATE AND COMMENT</th>
                                <th>PRODUCT STATUS</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $finalResults = array();
                            $query = "SELECT o.*, p.* FROM orders o LEFT JOIN products p ON p.product_id = o.product_id WHERE order_rating IN (1, 2, 3)";
                            $result = mysqli_query($conn, $query);                            
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $finalResults[] = $row;
                                }
                            foreach ($finalResults as $row) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $row['product_name']; ?></td>
                                <td class="text-center"><?php echo $row['order_qty'] . ' kilo'; ?></td>
                                <td class="text-center"><?php echo CURRENCY . number_format($row['order_qty'], 2); ?></td>
                                <td class="text-center">
                                <?php 
                                    $SellerID = $row['seller_id'];
                                    $SellerName = "SELECT fullname FROM users WHERE user_id = $SellerID";
                                    $SellerRes = mysqli_query($conn, $SellerName);
                                    $rrow = mysqli_fetch_assoc($SellerRes);
                                    $SellerFullName = $rrow['fullname'];

                                    echo $SellerFullName;
                                ?>
                                 </td>
                                 <td class="text-center">
                                <?php 
                                    $BuyerID = $row['user_id'];
                                    $BuyerName = "SELECT fullname FROM users WHERE user_id = $BuyerID";
                                    $BuyerRes = mysqli_query($conn, $BuyerName);
                                    $rrrow = mysqli_fetch_assoc($BuyerRes);
                                    $BuyerFullName = $rrrow['fullname'];

                                    echo $BuyerFullName;
                                ?>
                                 </td>
                                 <td class="text-center">
                                    <?php
                                    echo 'ORDER RATING: ';
                                    for ($i = 0; $i < $row['order_rating']; $i++) {
                                        echo '<span class="star">&#9733;</span>';
                                    }
                                    echo '</br>';
                                    echo 'ORDER COMMENT: ' . $row['order_comm'];
                                    ?>
                                </td>
                                <td class="text-center" style="color: <?php if($row['product_status'] == 'On Sale'){echo 'green';}elseif($row['product_status'] == 'Restricted'){ echo 'red';} else {echo 'blue';}?>"><?php echo $row['product_status']; ?></td>
                                <td>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#restrictModal<?php echo $row['product_id']; ?>" class="btn btn-sm m-0"><ion-icon name="expand-outline"></ion-icon></button>
                                </td>
                            </tr>
                            <div class="modal fade" id="restrictModal<?php echo $row['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="restrictModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <img style="height: auto; width: 100%;" src="./images/<?php echo $row['product_img']; ?>" alt="<?php echo $row['product_name']; ?>">
                                                </div>
                                                <div class="col-6">
                                                    <p><b>Name:</b> <?php echo $row['product_name']; ?></p>
                                                    <p><b>Product Price:</b> <?php echo CURRENCY . number_format($row['product_price'], 2); ?> per kg</p>
                                                    <p><b>Stock:</b> <?php echo $row['product_stock'] ?> kg</p>
                                                    <p><b>Minimum Order:</b> <?php echo $row['min_order'] ?> kg</p>
                                                    <p><b>Seller:</b> <?php echo $SellerFullName; ?></p>
                                                    <p><b>Status:</b> <?php echo $row['product_status']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <form action="" method="POST">
                                            <input type="hidden" name="pID" value="<?php echo $row['product_id']; ?>">
                                            <input type="hidden" name="sID" value="<?php echo $SellerID ?>">
                                            <div class="d-flex-inline">
                                                <button type="submit" class="btn btn-warning" name="restrict_product">Restrict Product</button>
                                                <button type="submit" class="btn btn-danger" name="restrict_seller">Restrict Seller</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>