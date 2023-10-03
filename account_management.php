<?php 
require_once './includes/db.php';

// Fetch Buyer Accounts
$buyerAccountsQuery = "SELECT * FROM users WHERE user_type = 'Buyer'";
$buyerAccountsResult = mysqli_query($conn, $buyerAccountsQuery);

// Fetch Seller Accounts
$sellerAccountsQuery = "SELECT * FROM users WHERE user_type = 'Seller'";
$sellerAccountsResult = mysqli_query($conn, $sellerAccountsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCOUNT MANAGEMENT</title>
    <?php require_once './includes/head.php'; ?>
</head>
<body class="pad">
    <div class="container">
        <?php require_once './includes/sidenav.php';?>
        <div class="row">
            <h1 style="padding-top: 10px;">ACCOUNTS</h1>
            <div class="col-md-12">
                <div class="table">
                    <table class="table table-responsive table-sm">
                        <thead class="text-center">
                            <tr>
                                <th colspan="5">BUYER ACCOUNTS</th>
                            </tr>
                        </thead>
                        <thead class="text-center">
                            <tr>
                                <th>NAME</th>
                                <th>ADDRESS</th>
                                <th>LAST LOGIN</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php while ($buyer = mysqli_fetch_assoc($buyerAccountsResult)) { ?>
                                <tr>
                                    <td><?php echo $buyer['fullname']; ?></td>
                                    <td><?php echo $buyer['address']; ?></td>
                                    <td><?php echo $buyer['last_login']; ?></td>
                                    <td><?php echo $buyer['sts']; ?></td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#buyerInfoModal<?php echo $buyer['user_id']; ?>"><ion-icon name="information-circle-outline"></ion-icon></button>
                                        <div class="modal fade" id="buyerInfoModal<?php echo $buyer['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="buyerInfoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="buyerInfoModalLabel">ORDERS</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-sm">
                                                            <thead class="table-light text-center">
                                                                <tr>
                                                                    <th>PRODUCT</th>
                                                                    <th>ORDER QTY</th>
                                                                    <th>TOTAL AMT</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="text-center">
                                                                <?php
                                                                    $sql = "SELECT o.*, p.product_name
                                                                    FROM orders o
                                                                    INNER JOIN users u ON o.user_id = u.user_id
                                                                    INNER JOIN products p ON p.product_id = o.product_id
                                                                    WHERE o.user_id = '{$buyer['user_id']}'
                                                                    ORDER BY o.date_place DESC";

                                                                    $result = mysqli_query($conn, $sql);

                                                                    foreach($result as $row){
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $row['product_name'] ?></td>
                                                                    <td><?php echo $row['order_qty'] ?></td>
                                                                    <td><?php echo CURRENCY . number_format($row['order_total'], 2) ?></td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table">
                    <table class="table table-responsive table-sm">
                        <thead class="text-center">
                            <tr>
                                <th colspan="5">SELLER ACCOUNTS</th>
                            </tr>
                        </thead>
                        <thead class="text-center">
                            <tr>
                                <th>NAME</th>
                                <th>ADDRESS</th>
                                <th>LAST LOGIN</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php while ($seller = mysqli_fetch_assoc($sellerAccountsResult)) { ?>
                                <tr>
                                    <td><?php echo $seller['fullname']; ?></td>
                                    <td><?php echo $seller['address']; ?></td>
                                    <td><?php echo $seller['last_login']; ?></td>
                                    <td><?php echo $seller['sts']; ?></td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#sellerInfoModal<?php echo $seller['user_id']; ?>"><ion-icon name="information-circle-outline"></ion-icon></button>
                                        <div class="modal fade" id="sellerInfoModal<?php echo $seller['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="sellerInfoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="sellerInfoModalLabel">Seller Information</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>Products by <?php echo $seller['fullname']; ?></h4>
                                                        <table class="table table-responsive table-sm">
                                                            <thead class="text-center">
                                                                <tr>
                                                                    <th>Product Name</th>
                                                                    <th>Price</th>
                                                                    <th>Stock</th>
                                                                    <!-- Add more columns as needed -->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                // SQL query to get the products associated with the seller
                                                                $seller_id = $seller['user_id'];
                                                                $product_query = "SELECT * FROM products WHERE seller_id = '$seller_id'";
                                                                $product_result = mysqli_query($conn, $product_query);

                                                                while ($product = mysqli_fetch_assoc($product_result)) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $product['product_name']; ?></td>
                                                                        <td><?php echo CURRENCY . number_format($product['product_price'], 2); ?></td>
                                                                        <td><?php echo $product['product_stock'] . ' kg'; ?></td>
                                                                        <!-- Add more columns as needed -->
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
