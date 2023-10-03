<?php 
    require_once './includes/db.php';

    $admin = $_SESSION['user_id'];
    $query = "SELECT user_type FROM users WHERE user_id = '$admin'";
    $que = mysqli_query($conn, $query);
    $s = mysqli_fetch_assoc($que);
    $r = $s['user_type'];

    if($r != 'Admin'){
        header("location: ./index.php");
    }else{
    }
// Execute the SQL queries and fetch the results
    $totalOrdersQuery = "SELECT COUNT(*) AS total_orders FROM orders";
    $totalSalesQuery = "SELECT SUM(order_total) AS total_sales FROM orders";
    $activeUsersQuery = "SELECT COUNT(*) AS active_users FROM users WHERE sts = 'Active'";
    $totalProductsQuery = "SELECT COUNT(*) AS total_products FROM products";

    $totalOrdersResult = mysqli_query($conn, $totalOrdersQuery);
    $totalSalesResult = mysqli_query($conn, $totalSalesQuery);
    $activeUsersResult = mysqli_query($conn, $activeUsersQuery);
    $totalProductsResult = mysqli_query($conn, $totalProductsQuery);

    // Fetch data from results
    $totalOrders = mysqli_fetch_assoc($totalOrdersResult)['total_orders'];
    $totalSales = mysqli_fetch_assoc($totalSalesResult)['total_sales'];
    $activeUsers = mysqli_fetch_assoc($activeUsersResult)['active_users'];
    $totalProducts = mysqli_fetch_assoc($totalProductsResult)['total_products'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN MANAGEMENT</title>
    <?php require_once './includes/head.php'; ?>
</head>
<body class="pad">
    <div class="container">
        <?php require_once './includes/sidenav.php';?>
        <div class="row">
        <h1 style="padding-top: 10px;">ADMIN DASHBOARD</h1>
            <div class="col-xl-3 col-md-4 mb-4">
                <div class="card shadow py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-primary text-uppercase mb-1" style="font-size: small;">
                                    TOTAL ORDERS</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: x-large;"><?php echo $totalOrders ?></div>
                            </div>
                            <div class="col-auto text-primary">
                                <ion-icon size="large" name="receipt-outline"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 mb-4">
                <div class="card card-custom shadow py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-info text-uppercase mb-1" style="font-size: small;">
                                    TOTAL SALES</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: x-large;"><?php echo CURRENCY . number_format($totalSales, 2) ?></div>
                            </div>
                            <div class="col-auto text-info">
                                <ion-icon size="large" name="bar-chart-outline"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 mb-4">
                <div class="card card-custom shadow py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-warning text-uppercase mb-1" style="font-size: small;">
                                    ACTIVE USERS</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: x-large;"><?php echo $totalOrders ?></div>
                            </div>
                            <div class="col-auto text-warning">
                                <ion-icon size="large" name="people-circle-outline"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 mb-4">
                <div class="card card-custom shadow py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-success text-uppercase mb-1" style="font-size: small;">
                                    PRODUCTS</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: x-large;"><?php echo $totalProducts ?></div>
                            </div>
                            <div class="col-auto text-success">
                                <ion-icon size="large" name="nutrition-outline"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
            <h3>HOT PRODUCTS</h3>
                <div class="row row-cols-3 row-cols-md-3">
                    <?php 
                        $hot = "SELECT product_id, COUNT(*) AS order_count
                        FROM orders
                        GROUP BY product_id
                        ORDER BY order_count DESC
                        LIMIT 3";
                        $hotresult = mysqli_query($conn, $hot);
                        foreach($hotresult as $hotRow){
                            $product_id = $hotRow['product_id'];
                            $count = $hotRow['order_count'];
                    ?>
                        <div class="card">
                            <?php 
                                $cardHot = "SELECT * FROM products WHERE product_id = '$product_id'";
                                $cardRes = mysqli_query($conn, $cardHot);
                                $cardHotRow = mysqli_fetch_assoc($cardRes);
                            ?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img style="max-height: 15em; width: 100%;" src="./images/<?= $cardHotRow['product_img'] ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <p style="text-transform: capitalize;"><b><?php echo $cardHotRow['product_name'] ?></b></p>
                                        <p><b><?php echo $count ?> TOTAL ORDERS</b></p>
                                        <?php 
                                            $Cardseller = "SELECT fullname, address FROM users WHERE user_id = '{$cardHotRow['seller_id']}'";
                                            $SellerRes = mysqli_query($conn, $Cardseller);
                                            $SellerRow = mysqli_fetch_assoc($SellerRes);
                                        ?>
                                            <?php echo $SellerRow['fullname'] ?>
                                            <?php echo 'ADDRESS: ' . $SellerRow['address'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="table shadow-sm">
                    <table class="table table-info table-responsive table-sm">
                            <thead class="text-center">
                                <tr>
                                    <th colspan="4">RECENT ORDERS</th>
                                </tr>
                            </thead>
                                <thead class="table-light text-center">
                                <tr>
                                    <th>BUYER</th>
                                    <th>PRODUCT</th>
                                    <th>ORDER QTY</th>
                                    <th>TOTAL AMT</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            <?php
                                $sql = "SELECT o.*, u.fullname, p.product_name
                                        FROM orders o
                                        INNER JOIN users u ON o.user_id = u.user_id
                                        INNER JOIN products p ON p.product_id = o.product_id
                                        ORDER BY o.date_place DESC 
                                        LIMIT 8";

                                $result = mysqli_query($conn, $sql);

                                foreach($result as $row){
                            ?>
                                <tr>
                                    <td><?php echo $row['fullname'] ?></td>
                                    <td><?php echo $row['product_name'] ?></td>
                                    <td><?php echo $row['order_qty'] ?></td>
                                    <td><?php echo $row['order_total'] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <h4 class="text-center bg-white text-success">RECENT PRODUCTS</h4>
                    <?php 
                    $recent = "SELECT p.*, u.fullname AS seller_fullname
                            FROM products p
                            INNER JOIN users u ON p.seller_id = u.user_id
                            WHERE p.product_status = 'On Sale' AND p.product_stock > p.min_order
                            ORDER BY p.date_added DESC
                            LIMIT 3";

                    $recentResult = mysqli_query($conn, $recent);

                    while ($row1 = mysqli_fetch_assoc($recentResult)) {
                    ?>
                        <div class="card mb-1" style="height: 6em;">
                            <div class="card-body">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <img  style="width: 100%; height: 4em; max-width: 4em;" src="./images/<?= $row1['product_img'] ?>">
                                        </div>
                                        <div class="col-8 text-start" style="font-size: 10px;">
                                            <h6 class="card-title"><?= $row1['product_name']; ?></h6>
                                            Seller: <?= $row1['seller_fullname']; ?><br>
                                            Price: <?= CURRENCY .  number_format($row1['product_price'], 2) ?> per kg<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>