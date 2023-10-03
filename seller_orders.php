<?php
    require_once './includes/db.php';
    $user_idS = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Orderlist</title>
    <?php require_once './includes/head.php'; ?>
</head>
<body class="pad">
    <div class="container">
        <?php require_once './includes/sidenav.php';?>
        <div class="row">
            <div class="col-11">
                <h1 style="padding-top: 10px;">ORDER LIST</h1>
            </div>
            <div class="col-1 d-flex float-end">
                <?php require_once './extension/notif_seller.php';?>
            </div>
        </div>
            <div class="col">
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
                            if(isset($_GET['delivered'])){
                                $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE seller_id = '$user_id' AND order_status = 'Delivered' ORDER BY date_place DESC";
                                $result = mysqli_query($conn, $query);
                            }elseif (isset($_GET['trancode'])) {
                                $code = $_GET['trancode'];
                                $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE seller_id = '$user_idS' AND order_reference = '$code'";
                                $result = mysqli_query($conn, $query);
                            }elseif(isset($_POST['confirmed'])){
                                $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE seller_id = '$user_id' AND order_status = 'Confirmed' ORDER BY date_place DESC";
                                $result = mysqli_query($conn, $query);
                            }elseif(isset($_POST['cancel'])){
                                $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE seller_id = '$user_id' AND order_status = 'Cancelled' ORDER BY date_place DESC";
                                $result = mysqli_query($conn, $query);
                            }elseif(isset($_POST['pick'])){
                                $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE seller_id = '$user_id' AND order_status = 'Picked Up' ORDER BY date_place DESC";
                                $result = mysqli_query($conn, $query);
                            }elseif(isset($_POST['pending'])){
                                $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE seller_id = '$user_id'AND order_status = 'Pending' ORDER BY date_place DESC";
                                $result = mysqli_query($conn, $query);
                            }elseif(isset($_POST['all'])){
                                $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE seller_id = '$user_id' ORDER BY date_place DESC";
                                $result = mysqli_query($conn, $query);
                            }else{
                            $query = "SELECT DISTINCT order_reference, order_status, date_place, transact_mode, order_rating, order_comm FROM orders WHERE seller_id = '$user_id' AND order_status != 'Cancelled' ORDER BY date_place DESC";
                            $result = mysqli_query($conn, $query);
                            }
                            foreach($result as $row){
                                $order_ref = $row['order_reference'];
                                $order_rating = $row['order_rating'];
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
                                            <td>TOTAL AMOUNT</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $queryO = "SELECT product_id, order_qty, order_total FROM orders WHERE order_reference = '$order_ref'";
                                            $queryR = mysqli_query($conn, $queryO);

                                            while($rowO = mysqli_fetch_assoc($queryR)){
                                                $product_id = $rowO['product_id'];
                                                $queryP = "SELECT * FROM products WHERE product_id = '$product_id'";
                                                $queryPR = mysqli_query($conn, $queryP);

                                                while($rowP = mysqli_fetch_assoc($queryPR)){
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
                                </table>
                                <?php 
                                    $queryOrderInfo = "SELECT transact_mode, user_id, date_place, order_delivery_date FROM orders WHERE order_reference = '$order_ref'";
                                    $orderInfoResult = mysqli_query($conn, $queryOrderInfo);

                                    if ($orderInfoRow = mysqli_fetch_assoc($orderInfoResult)) {
                                        $transact_mode = $orderInfoRow['transact_mode'];
                                        $user_id1 = $orderInfoRow['user_id'];

                                        // Retrieve user information from the users table
                                        $queryUserInfo = "SELECT * FROM users WHERE user_id = '$user_id1'";
                                        $userInfoResult = mysqli_query($conn, $queryUserInfo);

                                        if ($userInfoRow = mysqli_fetch_assoc($userInfoResult)) {
                                            // Display transact_mode and user info
                                ?>
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <p class="card-text"><b>Name: </b><?php echo $userInfoRow['fullname']; ?></p>
                                                </div>
                                                <div class="col-4">
                                                    <p class="card-text"><b>Address: </b><?php echo $userInfoRow['address']; ?></p>
                                                </div>
                                                <div class="col-5">
                                                    <p class="card-text"><b>Contact Number: </b><?php echo $userInfoRow['number']; ?></p>
                                                </div>
                                            </div>
                                            <div class="row bg-light">
                                                <div class="col-6">
                                                    <p class="card-text"><b>Transaction Mode:</b> <?php echo $transact_mode ?></p>
                                                </div>
                                                <div class="col-6">
                                                <?php 
                                                    if($transact_mode == 'Pick Up'){
                                                        $userpicup = "SELECT pickup_address FROM users WHERE user_id = '$user_id'";
                                                        $res = mysqli_query($conn, $userpicup);
                                                        while($r = mysqli_fetch_assoc($res)){
                                                            $pick_up = $r['pickup_address'];
                                                        } echo '<b>Pick Up Location:</b> ' . $pick_up;
                                                    }else{
                                                        echo '<b>Delivery Address:</b> ' . $userInfoRow['delivery_area'];
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
                                <?php echo $row['order_status']; 
                                    if($row['transact_mode'] == 'Pick Up'){
                                        if($row['order_status'] == 'Pending'){
                                        ?>
                                        <form action="./extension/notif_sms_updateOrder.php" method="POST">
                                            <input type="hidden" name="transact" value="<?php echo $row['transact_mode'] ?>">
                                            <input type="hidden" name="def_stat" value="<?php echo $row['order_status'] ?>">
                                            <input type="hidden" name="seller_id" value="<?php echo $user_id ?>">
                                            <input type="hidden" name="buyer_id" value="<?php echo $user_id1 ?>">
                                            <input type="hidden" name="number" value="<?php echo $userInfoRow['number'] ?>">
                                            <input type="hidden" name="status" value="Approved">
                                            <input type="hidden" name="order_ref" value="<?php echo $order_ref; ?>">
                                            <input type="hidden" name="message" value="<?php echo 'Hi ' . $userInfoRow['fullname'] . ',' . 'your order with transaction mode Pick up and order reference:' . $order_ref . 'is now approved by the seller.' ?>">
                                            <div class="input-group mt-3">
                                                <span class="input-group-text">Date of Pick Up</span>
                                                <input type="date" class="form-control" name="date">
                                            </div>
                                            <div class="input-group mb-3 mt-3">
                                                <span class="input-group-text">Time of Pick Up</span>
                                                <input type="time" class="form-control" name="time">
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-outline-success" name="change_status">APPROVED</button>
                                        </form>
                                                <button type="button" class="btn btn-outline-warning" name="cancel" data-bs-toggle="modal" data-bs-target="#cancelO<?php echo $order_ref ?>">Cancel</button>
                                            </div>
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
                                                                <td>TOTAL AMOUNT</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $totalS = 0;
                                                                $queryO = "SELECT product_id, order_qty, order_total FROM orders WHERE order_reference = '$order_ref'";
                                                                $queryR = mysqli_query($conn, $queryO);

                                                                while($rowO = mysqli_fetch_assoc($queryR)){
                                                                    $product_id = $rowO['product_id'];
                                                                    $queryP = "SELECT * FROM products WHERE product_id = '$product_id'";
                                                                    $queryPR = mysqli_query($conn, $queryP);
                                                                    $totalS += $rowO['order_total'];
                                                                    while($rowP = mysqli_fetch_assoc($queryPR)){
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
                                                        </tfoot>
                                                    </table>
                                                        Are you sure you want to cancel this order?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <form action="./extension/cancel_order.php" method="POST">
                                                            <input type="hidden" name="transact" value="<?php echo $order_ref ?>">
                                                            <input type="hidden" name="seller" value="<?php echo $user_id ?>">
                                                            <button type="submit" class="btn btn-danger" name="cancel">Cancel Order</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       <?php } elseif($row['order_status'] == 'Approved'){ ?>
                                        <form action="./extension/notif_sms_updateOrder.php" method="POST">
                                        <input type="hidden" name="def_stat" value="<?php echo $row['order_status'] ?>">
                                            <input type="hidden" name="transact" value="<?php echo $row['transact_mode'] ?>">
                                            <input type="hidden" name="seller_id" value="<?php echo $user_id ?>">
                                            <input type="hidden" name="buyer_id" value="<?php echo $user_id1 ?>">
                                            <input type="hidden" name="number" value="<?php echo $userInfoRow['number'] ?>">
                                            <input type="hidden" name="status" value="On the way to pick up location">
                                            <input type="hidden" name="order_ref" value="<?php echo $order_ref; ?>">
                                            <input type="hidden" name="message" value="<?php echo 'Hi ' . $userInfoRow['fullname'] . ',' . 'your order with transaction mode Pick up and order reference:' . $order_ref . 'is on the way to pick up location.' ?>">
                                            <button type="submit" class="btn btn-outline-success" name="change_status">OTW TO PICK UP LOCATION</button>
                                        </form>
                                        <?php } elseif($row['order_status'] == 'On the way to pick up location'){ ?>
                                        <form action="./extension/notif_sms_updateOrder.php" method="POST">
                                        <input type="hidden" name="def_stat" value="<?php echo $row['order_status'] ?>">
                                            <input type="hidden" name="transact" value="<?php echo $row['transact_mode'] ?>">
                                            <input type="hidden" name="seller_id" value="<?php echo $user_id ?>">
                                            <input type="hidden" name="buyer_id" value="<?php echo $user_id1 ?>">
                                            <input type="hidden" name="number" value="<?php echo $userInfoRow['number'] ?>">
                                            <input type="hidden" name="status" value="Ready to pick up">
                                            <input type="hidden" name="order_ref" value="<?php echo $order_ref; ?>">
                                            <input type="hidden" name="message" value="<?php echo 'Hi ' . $userInfoRow['fullname'] . ',' . 'your order with transaction mode Pick up and order reference:' . $order_ref . 'is now ready to pick up.' ?>">
                                            <button type="submit" class="btn btn-outline-success" name="change_status">READY TO PICK UP</button>
                                        </form>
                                        <?php } elseif($row['order_status'] == 'Ready to pick up'){ ?>
                                        <form action="./extension/notif_sms_updateOrder.php" method="POST">
                                        <input type="hidden" name="def_stat" value="<?php echo $row['order_status'] ?>">
                                            <input type="hidden" name="transact" value="<?php echo $row['transact_mode'] ?>">
                                            <input type="hidden" name="seller_id" value="<?php echo $user_id ?>">
                                            <input type="hidden" name="buyer_id" value="<?php echo $user_id1 ?>">
                                            <input type="hidden" name="number" value="<?php echo $userInfoRow['number'] ?>">
                                            <input type="hidden" name="status" value="Picked up">
                                            <input type="hidden" name="order_ref" value="<?php echo $order_ref; ?>">
                                            <input type="hidden" name="message" value="<?php echo 'Hi ' . $userInfoRow['fullname'] . ',' . 'your order with transaction mode Pick up and order reference:' . $order_ref . 'is now already been picked up. Please leave a rating and comment on our service and product. Thank you!.' ?>">
                                            <button type="submit" class="btn btn-outline-success" name="change_status">PICKED UP</button>
                                        </form>
                                        <?php } else{ ?>
                                            <div class="text-center">
                                                <h6><b>ORDER RATING:</b></h6>
                                                <?php 
                                                    for($i = 0; $i < $order_rating; $i++) {
                                                        echo '<span class="star">&#9733;</span>';
                                                    }
                                                ?>
                                                <h6><b>ORDER COMMENT:</b></h6>
                                                <span><?php echo $row['order_comm']; ?></span>
                                            </div>
                                        <?php } 
                                    }elseif($row['transact_mode'] == 'Deliver'){
                                        if($row['order_status'] == 'Pending'){
                                        ?>
                                        <form action="./extension/notif_sms_updateOrder.php" method="POST">
                                            <input type="text" name="def_stat" value="<?php echo $row['order_status'] ?>">
                                            <input type="hidden" name="transact" value="<?php echo $row['transact_mode'] ?>">
                                            <input type="hidden" name="seller_id" value="<?php echo $user_id ?>">
                                            <input type="hidden" name="buyer_id" value="<?php echo $user_id1 ?>">
                                            <input type="hidden" name="number" value="<?php echo $userInfoRow['number'] ?>">
                                            <input type="hidden" name="status" value="Approved">
                                            <input type="hidden" name="order_ref" value="<?php echo $order_ref; ?>">
                                            <input type="hidden" name="message" value="<?php echo 'Hi ' . $userInfoRow['fullname'] . ',' . 'your order with transaction mode Deliver and order reference:' . $order_ref . 'is now approved by the seller.' ?>">
                                            <div class="input-group mt-3 mb-3">
                                                <span class="input-group-text">Date of Delivery</span>
                                                <input type="date" class="form-control" name="date">
                                            </div>
                                            <button type="button" class="btn btn-outline-warning" name="cancel" data-bs-toggle="modal" data-bs-target="#cancel">Cancel</button>
                                            <button type="submit" class="btn btn-outline-success" name="change_status">APPROVED</button>
                                        </form>
                                        <?php } elseif($row['order_status'] == 'Approved'){ ?>
                                        <form action="./extension/notif_sms_updateOrder.php" method="POST">
                                        <input type="hidden" name="def_stat" value="<?php echo $row['order_status'] ?>">
                                            <input type="hidden" name="transact" value="<?php echo $row['transact_mode'] ?>">
                                            <input type="hidden" name="seller_id" value="<?php echo $user_id ?>">
                                            <input type="hidden" name="buyer_id" value="<?php echo $user_id1 ?>">
                                            <input type="hidden" name="number" value="<?php echo $userInfoRow['number'] ?>">
                                            <input type="hidden" name="status" value="Out for delivery">
                                            <input type="hidden" name="order_ref" value="<?php echo $order_ref; ?>">
                                            <input type="hidden" name="message" value="<?php echo 'Hi ' . $userInfoRow['fullname'] . ',' . 'your order with transaction mode Deliver and order reference:' . $order_ref . 'is out for delivery.' ?>">
                                            <button type="submit" class="btn btn-outline-success" name="change_status">OUT FOR DELIVERY</button>
                                        </form>
                                        <?php } elseif($row['order_status'] == 'Out for delivery'){ ?>
                                        <form action="./extension/notif_sms_updateOrder.php" method="POST">
                                        <input type="hidden" name="def_stat" value="<?php echo $row['order_status'] ?>">
                                            <input type="hidden" name="transact" value="<?php echo $row['transact_mode'] ?>">
                                            <input type="hidden" name="seller_id" value="<?php echo $user_id ?>">
                                            <input type="hidden" name="buyer_id" value="<?php echo $user_id1 ?>">
                                            <input type="hidden" name="number" value="<?php echo $userInfoRow['number'] ?>">
                                            <input type="hidden" name="status" value="Delivered">
                                            <input type="hidden" name="order_ref" value="<?php echo $order_ref; ?>">
                                            <input type="hidden" name="message" value="<?php echo 'Hi ' . $userInfoRow['fullname'] . ',' . 'your order with transaction mode Deliver and order reference:' . $order_ref . 'is delivered. Please rate and Leave us a comment.' ?>">
                                            <button type="submit" class="btn btn-outline-success" name="change_status">DELIVERED</button>
                                        </form>
                                        <?php } else{ ?>
                                            <div class="text-center">
                                                <h6><b>ORDER RATING:</b></h6>
                                                <?php 
                                                    for($i = 0; $i < $order_rating; $i++) {
                                                        echo '<span class="star">&#9733;</span>';
                                                    }
                                                ?>
                                                <h6><b>ORDER COMMENT:</b></h6>
                                                <span><?php echo $row['order_comm']; ?></span>
                                            </div>
                                        <?php 
                                        } 
                                    } 
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
