<?php
    require_once './includes/db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home</title>
    <?php require_once './includes/head.php'; ?>
    <style>
        .fade-in {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .fade-in.active {
            opacity: 1;
        }
    </style>
</head>
<body>
<?php require_once './includes/navbar.php';?>
    <div class="container">
        <div class="toast-container top-0 start-50 translate-middle-x mt-5 bg-success">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                <img src="" class="rounded me-2">
                <strong class="me-auto">E-FarmErce</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                </div>
            </div>
        </div>
        <div class="row cols-sm-2 justify-content-center">
            <div class="col-md-8 col-sm-8 pt-5 fade-in">
                <div id="slide" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="5000">
                            <img src="./images/product1.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h2>Bridging farmers and buyers thru technology.</h2>
                                <a href="products.php" class="btn btn-success"> BUY NOW</a>
                            </div>
                            </div>
                            <div class="carousel-item">
                            <img src="./images/product2.jpg" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h2>Bridging farmers and buyers thru technology.</h2>
                                <a href="products.php" class="btn btn-success"> BUY NOW</a>
                            </div>
                            </div>
                            <div class="carousel-item">
                                <img src="./images/product3.jpg" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <h2>Bridging farmers and buyers thru technology.</h2>
                                    <a href="products.php" class="btn btn-success"> BUY NOW</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 shadow mt-5 dash-scroll justify-content-center" style="height: 35.5em; display:block; overflow-y:scroll;">
                <div class="row">
                <?php
                    if (isset($_GET['navsearch'])) {
                        $searchkey = $_GET['navsearch'];
                        $query = "SELECT * FROM products 
                            WHERE (product_name LIKE ? OR product_cat LIKE ?)
                            AND product_status = 'On Sale'
                            AND product_stock > min_order
                            ORDER BY date_added DESC";
                            $searchkeyWithWildcards = '%' . $searchkey . '%';
                            $stmt = mysqli_prepare($conn, $query);
                            mysqli_stmt_bind_param($stmt, "ss", $searchkeyWithWildcards, $searchkeyWithWildcards);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                    }  else{ 
                        $product_query = "SELECT * FROM products WHERE product_status = 'On Sale' AND product_stock > min_order ORDER BY date_added DESC";
                        $result = mysqli_query($conn, $product_query);
                    }
                        foreach($result as $row){
                ?>
                <button class="btn" type="button mx-auto" data-bs-toggle="modal" data-bs-target="#itemModal<?=$row['product_id']?>">
                    <div class="card border custom-card mt-2 fade-in">
                        <div class="card-body custom-card-body text-end">
                            <div class="row">
                                <div class="col-6">
                                    <img  style="width: 8em;" src="./images/<?= $row['product_img'] ?>">
                                </div>
                                <div class="col-6">
                                    <?= $row['product_name'] ?><br>
                                    Price: <?= $row['product_price'] ?> PHP per kg<br>
                                    Stock: <?= $row['product_stock'] ?> kg<br>
                                </div>
                            </div>
                        </div>
                    </div>
                </button>
                <div class="modal fade" id="itemModal<?=$row['product_id']?>" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-7">
                                        <img style="height: auto; width: 100%;" src="./images/<?= $row['product_img'] ?>">
                                    </div>
                                    <div class="col-md-5">
                                        <b>Name:</b> <?= $row['product_name'] ?><br>
                                        <b>Product Price:</b><br> <?= CURRENCY .  number_format($row['product_price'],2) ?> per kg<br>
                                        <b> Stock:</b> <?= $row['product_stock'] ?>kg<br>
                                        <b>Minimum Order :</b>  <?= $row['min_order'] ?> kg<br>
                                        <b>Product Details:<br></b>  <?= $row['product_details'] ?><br>
                                        <div class="form-group mb-3 mt-3">
                                        <form action="./extension/add_cart.php" method="POST">
                                            <label for="qty" class="mb-3"><b>Quantity</b></label>
                                            <input type="number" name="qty" class="form-control" value="<?php echo $row['min_order'] ?>" min="<?php echo $row['min_order'] ?>" max="<?php echo $row['product_stock'] ?>">
                                        </div>
                                        <div class="float-end d-flex">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                            <input type="hidden" name="product_id" value="<?= $row['product_id']; ?>">
                                            <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                                            <?php if ($user_id != 0) { ?>
                                                <button type="submit" class="btn btn-outline-success" name="addcart">Add to Cart</button>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-outline-success" onclick="openLoginModal(<?=$row['product_id']?>)">
                                                    Add to Cart
                                                </button>
                                            <?php  } ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function openLoginModal(product_id) {
                        $('#itemModal' + product_id).modal('hide');
                        $('#loginModal').modal('show'); 
                    }
                </script>
                <?php
                    }
                ?>
            </div>
            </div>
        </div>
    </div>
    <!-- <?php require_once 'products.php'; ?> -->
    <div class="container">
        <div class="row shadow border m-5 fade-in">
            <h1 class="text-center" style="color: green; margin-top: .5em;"><b>ABOUT US</b></h1>
            <div class="col-md-6 col-sm-6">
                <img src="./images/aboutus.png" class="img-fluid">
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="text-center p-4" style="margin-top: 3em;">
                <h2>We deliver clean, green, and fresh agricultural products.</h2>
                <h5>An online farmers' market that connects buyer directly to local farmers and producers. 
                    Browse and purchase fresh vegetables and fruits, and other relative agriculture products.</h5>
                </div>
            </div>
        </div>
        <div class="row border m-5">
            <h1 class="text-center pb-2" style="color: green; margin-top: .5em;"><b>CONTACT US</b></h1>
            <div class="col-md-3 col-sm-3 text-center">
                <a href=""><span><ion-icon name="logo-facebook" style="font-size: 2em;"></ion-icon></span></a>
                <p>FACEBOOK</p>
            </div>
            <div class="col-md-3 col-sm-3 text-center">
                <a href=""><span><ion-icon name="call-outline" style="font-size: 2em;">></ion-icon></span></a>
                <p>TEL. NUMBER</p>
            </div>
            <div class="col-md-3 col-sm-3 text-center">
                <a href=""><span><ion-icon name="location-outline" style="font-size: 2em;"></ion-icon></span></a>
                <p>ADDRESS</p>
            </div>
            <div class="col-md-3 col-sm-3 text-center">
                <a href=""><span><ion-icon name="mail-outline" style="font-size: 2em;"></ion-icon></span></a>
                <p>Email</p>
            </div>
        </div>
    </div>
</body>
<footer class="bg-dark text-white text-center p-4" style="margin-top: 5em; height: 5em;">
    <h6>E-FarmErce</h6>
    <p>&copy; 2023 All rights reserved</p>
</footer>
<script>
    // Add the 'active' class to elements with the 'fade-in' class when the page loads
    window.addEventListener('load', function () {
        var fadeElements = document.querySelectorAll('.fade-in');
        fadeElements.forEach(function (element) {
            element.classList.add('active');
        });
    });
</script>
<script>
    $(document).ready(function() {
        <?php
        if (isset($_SESSION['login_status'])) {
            if ($_SESSION['login_status'] === 'success') {
                // Show a success toast
                echo '$(".toast-body").text("Login successful!");';
            } elseif ($_SESSION['login_status'] === 'error') {
                // Show an error toast
                echo '$(".toast-body").text("Login failed. Incorrect password or email.");';
            }
            // Clear the login status session variable
            unset($_SESSION['login_status']);
            echo 'var liveToast = new bootstrap.Toast(document.getElementById("liveToast"));';
            echo 'liveToast.show();';
        }
        ?>
    });
</script>
</html>