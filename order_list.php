<?php
require_once './includes/db.php';

$user_idS = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <?php require_once './includes/head.php'; ?>
</head>
<body>
    <?php require_once './includes/navbar.php';?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 border my-3 text-center" style="color: green;">
                <h1>ORDERS LIST<ion-icon name="clipboard-sharp"></ion-icon></h1>
            </div>
            <div class="col-md-12">
                <form method="POST" action="">
                    <button type="submit" name="confirmed" class="float-end" style="background-color: transparent; border: 2px solid green; color: green; margin-left: 5px;">CONFIRMED</button>
                    <button type="submit" name="delivered" class="float-end" style="background-color: transparent; border: 2px solid green; color: green; margin-left: 5px;">DELIVERED</button>
                    <button type="submit" name="pending" class="float-end" style="background-color: transparent; border: 2px solid green; color: green; margin-left: 5px;">PENDING</button>
                    <button type="submit" name="all" class="float-end" style="background-color: transparent; border: 2px solid green; color: green; margin-left: 5px;">ALL</button>
                    <button type="submit" name="cancel" class="float-end" style="background-color: transparent; border: 2px solid green; color: green; margin-left: 5px;">CANCELLED</button>
                    <button type="submit" name="pick" class="float-end" style="background-color: transparent; border: 2px solid green; color: green;">PICKED UP</button>
                </form>
            </div>
            <div class="table table-responsive pt-3">
                <table class="table">
                    <thead class="text-center table-success">
                        <tr>
                            <td>ORDER REFERENCE</td>
                            <td>ORDER DETAILS</td>
                            <td>ORDER STATUS</td>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        if (isset($_POST['delivered'])) {
                            $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE user_id = '$user_idS' AND order_status = 'Delivered'";
                            $result = mysqli_query($conn, $query);
                        } elseif (isset($_GET['trancode'])) {
                            $code = $_GET['trancode'];
                            $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE user_id = '$user_idS' AND order_reference = '$code'";
                            $result = mysqli_query($conn, $query);
                        }elseif (isset($_POST['confirmed'])) {
                            $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE user_id = '$user_idS' AND order_status = 'Confirmed'";
                            $result = mysqli_query($conn, $query);
                        } elseif (isset($_POST['pick'])) {
                            $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE user_id = '$user_idS' AND order_status = 'Picked Up'";
                            $result = mysqli_query($conn, $query);
                        } elseif (isset($_POST['cancel'])) {
                            $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE user_id = '$user_idS' AND order_status = 'Cancelled'";
                            $result = mysqli_query($conn, $query);
                        }elseif (isset($_POST['pending'])) {
                            $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE user_id = '$user_idS'AND order_status = 'Pending'";
                            $result = mysqli_query($conn, $query);
                        } elseif (isset($_POST['all'])) {
                            $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE user_id = '$user_idS'";
                            $result = mysqli_query($conn, $query);
                        } else {
                            $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE user_id = '$user_idS' AND order_status != 'Cancelled'";
                            $result = mysqli_query($conn, $query);
                        }
                        foreach ($result as $row) {
                            $order_ref = $row['order_reference'];
                            $order_rating = $row['order_rating'];
                            $totalS = 0; // Initialize the total amount for each order to 0
                        ?>
                            <tr>
                                <td><?php echo $row['order_reference']; ?></td>
                                <td>
                                    <table class="table  table-sm">
                                        <thead class="table-success">
                                            <tr>
                                                <td>NAME</td>
                                                <td>PRICE</td>
                                                <td>QTY</td>
                                                <td>SUB AMOUNT</td>
                                                <td>Seller</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $queryO = "SELECT product_id, order_qty, order_total, seller_id FROM orders WHERE order_reference = '$order_ref' AND user_id = '$user_idS'";
                                            $queryR = mysqli_query($conn, $queryO);
                                            while ($rowO = mysqli_fetch_assoc($queryR)) {
                                                $product_id = $rowO['product_id'];
                                                $queryP = "SELECT * FROM products WHERE product_id = '$product_id'";
                                                $queryPR = mysqli_query($conn, $queryP);

                                                while ($rowP = mysqli_fetch_assoc($queryPR)) {
                                                    // Calculate and accumulate the total for each product in the order
                                                    $totalS += $rowO['order_total'];
                                                    $sellerId = $rowP['seller_id'];
                                                    $sellerQuery = "SELECT fullname, address, selfie_id FROM users WHERE user_id = '$sellerId'";
                                                    
                                                    $sellerQueryResult = mysqli_query($conn, $sellerQuery);
                                                    $sellerRow = mysqli_fetch_assoc($sellerQueryResult);
                                            ?>
                                                    <tr>
                                                        <td><?php echo $rowP['product_name'] ?></td>
                                                        <td><?php echo CURRENCY . number_format($rowP['product_price'], 2) ?></td>
                                                        <td><?php echo $rowO['order_qty'] ?></td>
                                                        <td><?php echo CURRENCY . number_format($rowO['order_total'], 2) ?></td>
                                                        <td><button  data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling" class="btn py-0 chat-seller" data-seller-id='<?php echo $sellerId ?>' data-user-id='<?php echo $user_idS ?>' data-seller-data='<?php echo json_encode($sellerRow)  ?>'><?php echo $sellerRow['fullname'] ?> <i class="bi bi-chat-left-fill ms-1"></i></button></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <td>TOTAL AMOUNT</td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo CURRENCY . number_format($totalS, 2) ?></td>
                                        </tfoot>
                                    </table>
                                    <?php
                                    $queryOrderInfo = "SELECT transact_mode, seller_id, date_place, order_delivery_date FROM orders WHERE order_reference = '$order_ref'";
                                    $orderInfoResult = mysqli_query($conn, $queryOrderInfo);

                                    if ($orderInfoRow = mysqli_fetch_assoc($orderInfoResult)) {
                                        $transact_mode = $orderInfoRow['transact_mode'];
                                        $seller_id = $orderInfoRow['seller_id'];

                                        $queryUserInfo = "SELECT * FROM users WHERE user_id = '$seller_id'";
                                        $userInfoResult = mysqli_query($conn, $queryUserInfo);

                                        if ($userInfoRow = mysqli_fetch_assoc($userInfoResult)) {
                                    ?>
                                            <div class="card mt-3">
                                                <div class="card-body">
                                                    <div class="row bg-light">
                                                        <div class="col-6">
                                                            <p class="card-text"><b>Transaction Mode:</b> <?php echo $transact_mode ?></p>
                                                        </div>
                                                        <div class="col-6">
                                                            <?php
                                                            if ($transact_mode == 'Pick Up') {
                                                                $userpicup = "SELECT pickup_address FROM users WHERE user_id = '$seller_id'";
                                                                $res = mysqli_query($conn, $userpicup);
                                                                while ($r = mysqli_fetch_assoc($res)) {
                                                                    $pick_up = $r['pickup_address'];
                                                                }
                                                                echo '<b>Pick Up Location:</b> ' . $pick_up;
                                                            } else {
                                                                $userloc = "SELECT delivery_area FROM users WHERE user_id = '$user_idS'";
                                                                $res1 = mysqli_query($conn, $userloc);
                                                                while ($r2 = mysqli_fetch_assoc($res1)) {
                                                                    $loc = $r2['delivery_area'];
                                                                    echo '<b>Delivery Address:</b> ' . $loc;
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p><b>DATE ORDERED:</b> <?php echo $orderInfoRow['date_place'] ?></p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p><b>TRANSACTION DATE:</b> <?php echo $orderInfoRow['order_delivery_date'] ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($row['order_status'] == 'Pending') { ?>
                                        <b><p> <?php echo $row['order_status'] ?> </p></b>
                                        <button class="btn btn-outline-white" type="button" data-bs-toggle="modal" data-bs-target="#cancelO<?php echo $order_ref ?>">Cancel</button>
                                        <div class="modal fade" id="cancelO<?php echo $order_ref ?>" tabindex="-1" role="dialog" aria-labelledby="cancelOModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="cancelOModalLabel">Cancel Order</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <table class="table  table-sm">
                                                        <thead class="table-success">
                                                            <tr>
                                                                <td>NAME</td>
                                                                <td>PRICE</td>
                                                                <td>QTY</td>
                                                                <td>SUB AMOUNT</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $queryO = "SELECT product_id, order_qty, order_total FROM orders WHERE order_reference = '$order_ref' AND user_id = '$user_idS'";
                                                            $queryR = mysqli_query($conn, $queryO);
                                                            while ($rowO = mysqli_fetch_assoc($queryR)) {
                                                                $product_id = $rowO['product_id'];
                                                                $queryP = "SELECT * FROM products WHERE product_id = '$product_id'";
                                                                $queryPR = mysqli_query($conn, $queryP);

                                                                while ($rowP = mysqli_fetch_assoc($queryPR)) {
                                                                    // Calculate and accumulate the total for each product in the order
                                                                    $totalS += $rowO['order_total'];
                                                            ?>
                                                                    <tr>
                                                                        <td><?php echo $rowP['product_name'] ?></td>
                                                                        <td><?php echo CURRENCY . number_format($rowP['product_price'], 2) ?></td>
                                                                        <td><?php echo $rowO['order_qty'] ?></td>
                                                                        <td><?php echo CURRENCY . number_format($rowO['order_total'], 2) ?></td>
                                                                        
                                                                    </tr>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <td>TOTAL AMOUNT</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><?php echo CURRENCY . number_format($totalS, 2) ?></td>
                                                            <td></td>
                                                        </tfoot>
                                                    </table>
                                                        Are you sure you want to cancel this order?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <form action="./extension/cancel_order.php" method="POST">
                                                            <input type="hidden" name="transact" value="<?php echo $order_ref ?>">
                                                            <input type="hidden" name="seller" value="<?php echo $seller_id ?>">
                                                            <button type="submit" class="btn btn-danger" name="cancel">Cancel Order</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } elseif ($row['order_status'] == 'Delivered' || $row['order_status'] == 'Picked up') { ?>
                                        <b><p> <?php echo $row['order_status'] ?> </p></b>
                                        <button class="btn btn-outline-warning" type="button" data-bs-toggle="modal" data-bs-target="#rate">RATE ORDER</button>
                                        <div class="modal fade" id="rate" tabindex="-1" role="dialog" aria-labelledby="rateModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="cancelOModalLabel">Rate and Comment on Order</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="./extension/rating_commPROCESS.php" method="POST">
                                                            <div class="form-group">
                                                                <label for="rating">Rating:</label>
                                                                <select class="form-control" id="rating" name="rating">
                                                                    <option value="5">5 Stars</option>
                                                                    <option value="4">4 Stars</option>
                                                                    <option value="3">3 Stars</option>
                                                                    <option value="2">2 Stars</option>
                                                                    <option value="1">1 Star</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="comment">Comment:</label>
                                                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                                            </div>
                                                            <input type="hidden" name="transact" value="<?php echo $order_ref ?>">
                                                            <input type="hidden" name="seller" value="<?php echo $seller_id ?>">
                                                            <button type="submit" class="btn btn-primary" name="rate">Submit</button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } elseif ($row['order_status'] == 'Confirmed') { 
                                            $que = "SELECT DISTINCT order_rating, order_comm FROM orders WHERE order_reference = '$order_ref'";
                                            $q = mysqli_query($conn, $que);

                                            if ($ratingCommentRow = mysqli_fetch_assoc($q)) {
                                                $order_rating = $ratingCommentRow['order_rating'];
                                                $order_comm = $ratingCommentRow['order_comm'];
                                                echo '<b>' . $row['order_status'] . '</b><br>';
                                                echo "Rating: $order_rating<br>";
                                                echo "Comment: $order_comm<br>";
                                            } else {
                                                echo "No rating and comment available for this order.<br>";
                                            }
                                        ?>
                                    <?php } else { ?>
                                        <b><p> <?php echo $row['order_status'] ?> </p></b>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php 
    include './includes/chat_canvas.php';
    ?>
    <script src="./js/chat_canvas.js"></script>
    <script src="./js/chat_icon.js"></script>
</body>
</html>
