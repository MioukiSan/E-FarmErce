<?php
    require_once './includes/db.php';

    $selectedProducts = $_POST['selected_products'];
    $productIds = array();
    $orderQuantities = array(); 
    $total = 0; 

    foreach ($selectedProducts as $cartId) {
        $query = "SELECT product_id, order_qty FROM cart WHERE cart_id = '$cartId'";
        $result = mysqli_query($conn, $query);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            $productIds[] = $row['product_id'];
            $orderQuantities[$row['product_id']] = $row['order_qty']; 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <?php require_once './includes/head.php'; ?>
    <style>
        .con-inventory {
            overflow-y:scroll;
            height: 55vh;
            width: 100%;
            margin: 1em 1em 1em 0;
        }
    </style>
</head>
<body>
    <div class="container pt-5">
        <div class="row pt-3 px-5 pb-5 border shadow">
            <div class="d-flex">
                <button class="btn" type="button" data-bs-target="#back" data-bs-toggle="modal" style="padding: 0;"><ion-icon size="large" name="arrow-back-circle"></ion-icon></button>
                <div class="modal fade" id="back" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: black;">CANCEL CHECKOUT</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p style="color: black;">Are you sure you want to cancel checkout?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="" method="GET">
                                    <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                                    <a href="products.php"class="btn btn-success">Proceed</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <h2><b>CHECKOUT</b></h2>
            </div>
            <div class="card con-inventory">
            <?php
                $selectedProducts = $_POST['selected_products'];
                $productIds = array();
                $orderQuantities = array(); 
                $total = 0; 

                foreach ($selectedProducts as $cartId) {
                    $query = "SELECT product_id, order_qty FROM cart WHERE cart_id = '$cartId'";
                    $result = mysqli_query($conn, $query);

                    if ($result && $row = mysqli_fetch_assoc($result)) {
                        $productIds[] = $row['product_id'];
                        $orderQuantities[$row['product_id']] = $row['order_qty']; 
                    }
                }

                $distinctSellerIds = [];

                foreach ($productIds as $productId) {
                    $query = "SELECT DISTINCT seller_id FROM products WHERE product_id = '$productId'";
                    $result = mysqli_query($conn, $query);

                    if ($result && $row = mysqli_fetch_assoc($result)) {
                        $sellerId = $row['seller_id'];

                        if (!in_array($sellerId, $distinctSellerIds)) {
                            $distinctSellerIds[] = $sellerId;
                        }
                    }
                }

                foreach ($distinctSellerIds as $sellerId):
                ?>
                <?php 
                    $seller_info = "SELECT * FROM users WHERE user_id ='$sellerId'";
                    $seller_res = mysqli_query($conn, $seller_info);
                
                    while($rrow = mysqli_fetch_assoc($seller_res)){
                ?>
                <div class="card bg-light d-flex mt-2">
                    <div class="row mt-1 mx-1">
                        <div class="col-md-4">
                            <h6>Seller: <?= $rrow['fullname']?></h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Contact Number: <?= $rrow['number'] ?></h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Seller Address: <?= $rrow['address'] ?></h6>
                        </div>
                    </div>
                </div>
                <div class="table mt-2">
                    <table class="table table-success table-borderless">
                        <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th class="text-center">ORDER DETAILS</th>
                                <th class="text-center">SUB TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sellerProductsQuery = "SELECT * FROM products WHERE seller_id = '$sellerId' AND product_id IN (" . implode(',', $productIds) . ")";
                            $sellerProductsResult = mysqli_query($conn, $sellerProductsQuery);
                            $sellerTotal = 0; 
                            $STotal = 0;
                            while ($row = mysqli_fetch_assoc($sellerProductsResult)):
                                $productId = $row['product_id'];
                                $order_qty = $orderQuantities[$productId];
                                $subtotal = $row['product_price'] * $order_qty;
                                $sellerTotal += $subtotal; 
                                $STotal += $sellerTotal; 

                        ?>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <img style=" width: 12em; height: 7em;" src="./images/<?= $row['product_img'] ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <p><?php echo $row['product_name']; ?></p>
                                            <p>Price: <?php echo $row['product_price']; ?> PHP per kg</p>
                                            <p>Stock: <?php echo $row['product_stock']; ?> KG</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <form action="./extension/change_orderqty.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $productId ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                                        <?php 
                                            foreach($selectedProducts as $ids){
                                        ?>
                                        <input type="hidden" name="selected_products[]" value="<?php echo $ids ?>">
                                        <?php } ?>
                                        <input type="number" name="quantity" class="form-control" value="<?php echo $order_qty ?>" min="<?= $carts['min_order'] ?>" max="<?= $productStock ?>" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td>
                                    <?php
                                        $total = 0;
                                        $subtotal = $row['product_price'] * $order_qty;
                                    ?>
                                    <p class="text-center"><?= CURRENCY . number_format($subtotal, 2) ?></p>
                                </td>
                            </tr>
                            <?php
                            endwhile;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                <div class="col-md-12 col-sm-12 mb-3">
                                    <form action="./extension/mode_transact.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $productId ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                                        <?php 
                                            foreach($selectedProducts as $ids){
                                        ?>
                                        <input type="hidden" name="selected_products[]" value="<?php echo $ids ?>">
                                        <?php } ?>
                                        <select class="form-control form-control-sm custom-form" aria-label="transact" name="transact" onchange="this.form.submit()">
                                            <?php 
                                                $user = $_SESSION['user_id'];

                                                // Fetch user's municipality
                                                $userMunicipalityQuery = "SELECT municipality FROM users WHERE user_id = '$user'";
                                                $userMunicipalityResult = mysqli_query($conn, $userMunicipalityQuery);
                                                $userMunicipalityRow = mysqli_fetch_assoc($userMunicipalityResult);
                                                $userMunicipality = $userMunicipalityRow['municipality'];

                                                $transact = "SELECT selected_mode FROM cart WHERE user_id = '$user' AND product_id = '$productId'";
                                                $resulttransact = mysqli_query($conn, $transact);
                                                $rowtransact = mysqli_fetch_assoc($resulttransact);
                                                $selected_mode = $rowtransact['selected_mode'];

                                                if ($selected_mode == 'Pick Up'){?>
                                                    <option value="Pick Up" selected>Pick Up (Location: <?php echo $rrow['pickup_address'] ?>)</option>
                                                    <?php
                                                    // Check if the user's municipality matches the delivery area
                                                    if ($userMunicipality != $rrow['delivery_area']) { ?>
                                                        <option value="Deliver" disabled>Deliver (Location: <?php echo $rrow['delivery_area'] ?>)</option>
                                                    <?php } else { ?>
                                                        <option value="Deliver">Deliver (Location: <?php echo $rrow['delivery_area'] ?>)</option>
                                                    <?php } ?>
                                                <?php } elseif ($selected_mode == 'Deliver'){ ?>
                                                    <option value="Pick Up">Pick Up (Location: <?php echo $rrow['pickup_address'] ?>)</option>
                                                    <?php
                                                    // Check if the user's municipality matches the delivery area
                                                    if ($userMunicipality != $rrow['delivery_area']) { ?>
                                                        <option value="Deliver" selected disabled>Deliver (Location: <?php echo $rrow['delivery_area'] ?>)</option>
                                                    <?php } else { ?>
                                                        <option value="Deliver" selected>Deliver (Location: <?php echo $rrow['delivery_area'] ?>)</option>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <option value="" disabled selected>Select Transaction Method</option>
                                                    <option value="Pick Up">Pick Up (Location: <?php echo $rrow['pickup_address'] ?>)</option>
                                                    <?php
                                                    // Check if the user's municipality matches the delivery area
                                                    if ($userMunicipality != $rrow['delivery_area']) { ?>
                                                        <option value="Deliver" disabled>Deliver (Location: <?php echo $rrow['delivery_area'] ?>)</option>
                                                    <?php } else { ?>
                                                        <option value="Deliver">Deliver (Location: <?php echo $rrow['delivery_area'] ?>)</option>
                                                    <?php } ?>
                                                <?php } ?>
                                        </select>
                                    </form>
                                </div>
                                </td>
                                <td><b><p>TOTAL</p></b></td>
                                <td>
                                    <p class="text-center"><?= CURRENCY . number_format($sellerTotal, 2) ?></p>
                                </td>
                            </tr>
                        </tfoot>
                        <?php 
                            }
                        ?>
                    </table>
                </div>
                <?php
                endforeach;
                ?>
            </div>
            <form action="./extension/checkoutproccess.php" method="POST" id="checkoutForm" onsubmit="return submitForm()">
                <?php foreach ($selectedProducts as $ids) { ?>
                    <input type="hidden" name="selected_products[]" value="<?php echo $ids ?>">
                <?php } ?>
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                <button type="submit" class="btn btn-outline-success">Checkout</button>
            </form>
        </div>
    </div>
</body>
<script>
    function submitForm() {
        var selectedMode = document.getElementsByName('transact')[0].value;

        // Check if selected_mode is empty or null
        if (selectedMode === '' || selectedMode === null) {
            alert('Please select a transaction method before checkout.');
            return false; // Prevent form submission
        }

        // If everything is fine, allow the form submission
        return true;
    }
</script>
</html> 