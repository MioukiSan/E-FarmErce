<?php
    require_once './includes/db.php';

    if(isset($_POST['quantity'])){
        $_SESSION['qty'] = $_POST['quantity'];
    }
    
    if(isset($_POST['name'])){
        $_SESSION['name'] = $_POST['name'];
    }
    if(isset($_POST['address'])){
        $_SESSION['address'] = $_POST['address'];
    }
    if(isset($_POST['contact_number'])){
        $_SESSION['number'] = $_POST['contact_number'];
    }
    if(isset($_POST['transaction_mode'])){
        $_SESSION['transaction_mode'] = $_POST['transaction_mode'];
    }
    if(isset($_POST['municipality'])){
        $_SESSION['municipality'] = $_POST['municipality'];
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
            height: auto;
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
                                <form action="./extension/cancel_checkout.php" method="POST">
                                    <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success" name="proceed">Proceed</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <h2><b>CHECKOUT</b></h2>
            </div>
            <div class="card con-inventory">
            <div class="row">
                <div class="col-md-8">
                        <?php 
                            $product_id = $_SESSION['product_id'];
                            $qty = $_SESSION['qty'];

                            $queryGET = "SELECT p.seller_id, p.product_stock, p.product_img, p.min_order, p.product_name, p.product_price, u.fullname, u.address, u.number 
                                    FROM products p
                                    LEFT JOIN users u ON p.seller_id = u.user_id
                                    WHERE p.product_id = $product_id";
                            $queryRes = mysqli_query($conn, $queryGET);
                            foreach($queryRes as $rrow){
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
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <img style=" width: 7em; height: 7em;" src="./images/<?= $rrow['product_img'] ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <p><?php echo $rrow['product_name']; ?></p>
                                                    <p>Price: <?php echo $rrow['product_price']; ?> PHP per kg</p>
                                                    <p>Stock: <?php echo $rrow['product_stock']; ?> KG</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="" method="POST">
                                                <label for="quantity" class="form-label">Order Quantity:</label>
                                                <input type="number" name="quantity" class="form-control" value="<?php echo $qty ?>" min="<?= $rrow['min_order'] ?>" max="<?= $productStock ?>" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td>
                                            <?php
                                                $total = 0;
                                                $subtotal = $rrow['product_price'] * $qty;
                                            ?>
                                            <p class="text-center"><?= CURRENCY . number_format($subtotal, 2) ?></p>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php 
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4 mt-1">
                        <h3>BILLING DETAILS</h3>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <input type="text" class="form-control form-control-sm" name="name" placeholder="Enter your name" value="<?php echo $_SESSION['name'] ?? ''; ?>" onchange="this.form.submit()">
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <input type="text" class="form-control form-control-sm" name="address" placeholder="Enter your Address" value="<?php echo $_SESSION['address'] ?? ''; ?>" onchange="this.form.submit()">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <select class="form-control form-control-sm" name="municipality" id="municipality" onchange="this.form.submit()" required>
                                        <option value="" disabled <?php echo (!isset($_SESSION['municipality'])) ? 'selected' : ''; ?>>Select Municipality</option>
                                        <?php
                                        $query = "SELECT DISTINCT municipality FROM location";
                                        $result = mysqli_query($conn, $query);

                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $selected = (isset($_SESSION['municipality']) && $_SESSION['municipality'] == $row['municipality']) ? 'selected' : '';
                                                echo "<option value='" . $row['municipality'] . "' $selected>" . $row['municipality'] . "</option>";
                                            }
                                            mysqli_free_result($result);
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control form-control-sm" name="contact_number" placeholder="Enter your Contact Number" value="<?php echo $_SESSION['number'] ?? ''; ?>" onchange="this.form.submit()">
                            </div>
                            <select class="form-control form-control-sm" name="transaction_mode" id="" onchange="this.form.submit()">
                                <option value="" disabled <?php echo (!isset($_SESSION['transaction_mode'])) ? 'selected' : ''; ?>>Choose transaction mode</option>
                                <option value="Pick Up" <?php echo (isset($_SESSION['transaction_mode']) && $_SESSION['transaction_mode'] == 'Pick Up') ? 'selected' : ''; ?>>Pick Up</option>
                                <option value="Delivery" <?php echo (isset($_SESSION['transaction_mode']) && $_SESSION['transaction_mode'] == 'Delivery') ? 'selected' : ''; ?>>Delivery</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <form action="./extension/checkoutnoaccountproccess.php" method="POST">
                <button type="submit" name="checkout_no_acc" class="btn btn-outline-success m-3 float-end">Checkout</button>
            </form>
        </div>
    </div>
</body>
</html> 