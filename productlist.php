<?php 
    require_once './includes/db.php';
    
    if(isset($_POST['restrict'])) {
        $productID = $_POST['pID'];
    
        // SQL query to update the product_status
        $updateSQL = "UPDATE products SET product_status = 'restricted' WHERE product_id = $productID";
    
        if(mysqli_query($conn, $updateSQL)) {
            echo "Product status updated to 'restricted' successfully.";
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
    <title>INVETORY</title>
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
            <h1 style="padding-top: 10px;">INVENTORY</h1>
            <div class="col-3 d-inline mt-3">
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
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="table">
                    <table class="table table-responsive table-sm">
                        <thead class="text-center table-light">
                            <tr>
                                <th>PRODUCT NAME</th>
                                <th>PRICE</th>
                                <th>STOCK</th>
                                <th>MINIMUM ORDER</th>
                                <th>SELLER</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $finalResults = array();

                            if (isset($_POST['sort'])) {
                                $sortValue = $_POST['sort'];
                                if ($sortValue === 'fruit') {
                                    $query = "SELECT p.*, u.fullname AS seller_fullname
                                            FROM products p
                                            INNER JOIN users u ON p.seller_id = u.user_id
                                            WHERE product_cat = 'fruit'
                                            ORDER BY date_added DESC";
                                    $results = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($results)) {
                                        $finalResults[] = $row;
                                    }
                                } elseif ($sortValue === 'vegetable') {
                                    $query = "SELECT p.*, u.fullname AS seller_fullname
                                            FROM products p
                                            INNER JOIN users u ON p.seller_id = u.user_id
                                            WHERE product_cat = 'vegetable'
                                            AND product_status = 'On Sale'
                                            AND product_stock > min_order
                                            ORDER BY date_added DESC";
                                    $results = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($results)) {
                                        $finalResults[] = $row;
                                    }
                                }
                            }elseif (isset($_GET['searchprod'])) {
                                $searchkey = $_GET['searchprod'];
                                $query = "SELECT p.*, u.fullname AS seller_fullname
                                          FROM products p
                                          INNER JOIN users u ON p.seller_id = u.user_id
                                          WHERE (product_name LIKE ? OR product_cat LIKE ? OR u.fullname LIKE ?)
                                          AND product_status = 'On Sale'
                                          AND product_stock > min_order
                                          ORDER BY date_added DESC";
                                $searchkeyWithWildcards = '%' . $searchkey . '%';
                                $stmt = mysqli_prepare($conn, $query);
                                mysqli_stmt_bind_param($stmt, "sss", $searchkeyWithWildcards, $searchkeyWithWildcards, $searchkeyWithWildcards);
                                mysqli_stmt_execute($stmt);
                                $results = mysqli_stmt_get_result($stmt);
                            
                                while ($row = mysqli_fetch_assoc($results)) {
                                    $finalResults[] = $row;
                                }
                            } else {
                                $query = "SELECT p.*, u.fullname AS seller_fullname
                                        FROM products p
                                        INNER JOIN users u ON p.seller_id = u.user_id";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $finalResults[] = $row;
                                }
                            }
                            foreach ($finalResults as $row) {
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $row['product_name']; ?></td>
                                <td class="text-center"><?php echo CURRENCY . number_format($row['product_price'], 2); ?></td>
                                <td class="text-center"><?php echo $row['product_stock'] . ' kg'; ?></td>
                                <td class="text-center"><?php echo $row['min_order'] . ' kg'; ?></td>
                                <td class="text-center"><?php echo $row['seller_fullname']; ?></td>
                                <td class="text-center" style="color: <?php if($row['product_status'] == 'On Sale'){echo 'green';}elseif($row['product_status'] == 'restricted'){ echo 'red';} else {echo 'blue';}?>"><?php echo $row['product_status']; ?></td>
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
                                                    <p><b>Seller:</b> <?php echo $row['seller_fullname']; ?></p>
                                                    <p><b>Status:</b> <?php echo $row['product_status']; ?></p>
                                                    <!-- Add more product details here -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <form action="" method="POST">
                                            <input type="hidden" name="pID" value="<?php echo $row['product_id']; ?>">
                                            <button type="submit" class="btn btn-danger" name="restrict">Restrict</button>
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