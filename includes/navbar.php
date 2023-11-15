<?php
    require_once './includes/db.php';

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $infos = "SELECT * FROM users WHERE user_id = '$user_id'";
        $r = mysqli_query($conn, $infos);
        $info = mysqli_fetch_assoc($r);

    }else{
        $user_id = 0;
    }
    if(isset($_GET['cart_delete'])) {
      $user_id = $_GET['user_id'];
      $cartId = $_GET['cart_id'];
  ?>
      <script>
          var confirmed = confirm("Are you sure you want to delete this item from your cart?");
          if (confirmed) {
              window.location.href = "./extension/delete_cart.php?user_id=<?php echo $user_id; ?>&cart_id=<?php echo $cartId; ?>";
          } else {
          }
      </script>
  <?php
  }

  $query1 = "SELECT COUNT(*) AS count FROM cart WHERE user_id = $user_id";
  $res = mysqli_query($conn, $query1);
  $row1 = mysqli_fetch_assoc($res);
  $count = $row1['count'];

  $query2 = "SELECT COUNT(*) AS count1 FROM notifications WHERE buyer_id = '$user_id' AND mess_status = 'Unread'";
  $res1 = mysqli_query($conn, $query2);
  $row2 = mysqli_fetch_assoc($res1);
  $count1 = $row2['count1'];

  $total_order = 0;
  $query3 = "SELECT COUNT(*) AS count2, SUM(order_total) AS total_order FROM orders WHERE user_id = '$user_id' AND order_status = 'Confirmed'";
  $res2 = mysqli_query($conn, $query3);
  $row3 = mysqli_fetch_assoc($res2);
  
  $count2 = $row3['count2']; 
  $total_order = $row3['total_order'];
  

?>
<nav class="navbar sticky-top navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="./index.php"> <img src="./images/logo.png" style="width: 4em;"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="width: .8em;"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav justify-content-center mx-auto">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="./index.php">HOME</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="./about_us.php">ABOUT US</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="./products.php">PRODUCTS</a>
            </li>
            <form id="search-form" action="?search_nav" method="GET" class="d-flex mx-4" role="search">
              <input class="form-control" type="search" name="navsearch" placeholder="Search products" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
           </form>
        </ul>
        <?php if($user_id == 0): ?>
        <ul class="nav-item pt-3">
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">SIGN IN</button>
        </ul>
        <?php else: ?>
          <ul class="nav-item pt-4 d-flex">
            <?php if($info['user_type'] == 'Seller') { ?>
            <a class="btn position-relative" data-bs-toggle="tooltip" data-bs-title="SWITCH TO SELLER UI" style=" color: green;" href="./seller.php"><ion-icon size="large" name="swap-horizontal-outline"></ion-icon></a>
            <?php } elseif( $info['user_type'] == 'Admin'){ ?>
              <a class="btn position-relative" data-bs-toggle="tooltip" data-bs-title="BACK TO ADMIN PAGE" style=" color: green;" href="./dashboard_admin.php"><ion-icon size="large" name="swap-horizontal-outline"></ion-icon></a>
            <?php } ?>
            <!-- Message Icon -->
              
              <div class="dropdown chat-dropdown">
              <a class="btn chat-dropdown-btn" data-user-id="<?PHP echo $user_id ?>" href="#" role="button" style="color: green;" data-bs-toggle="dropdown" aria-expanded="false">
               <ion-icon size="large" name="chatbubble-outline"></ion-icon>
              </a>
              <div class="dropdown-menu chat-dropdown-list container overflow-y-scroll overflow-x-hidden">
                
                <!-- users will be inserted dynamically -->
              </div>
            </div>
            <!-- End of Message Icon -->
            <button class="btn" style=" color: green;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><ion-icon size="large" name="cart-outline"></ion-icon>
            <span class="position-absolute top-40 start-170 translate-middle p-1">
              <?php echo $count ?><span class="visually-hidden">New alerts</span></button>
            <button type="button"style=" color: green;" class="btn position-relative" data-bs-toggle="offcanvas" data-bs-target="#notif" aria-controls="offcanvasRight">
            <ion-icon size="large" name="notifications-outline"></ion-icon>
            <?php if($count1 != 0){ ?>
              <span class="position-absolute top-40 start-170 translate-middle p-1 bg-danger border border-light rounded-circle">
                <span class="visually-hidden">New alerts</span>
              </span>
            <?php } else{} ?>
            </button> 
            <div class="dropdown">
              <a class="btn" href="#" role="button" style="color: green;" data-bs-toggle="dropdown" aria-expanded="false">
                <ion-icon size="large" name="person-circle-outline"></ion-icon>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="./order_list.php">Order List</a></li>
                <li><button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#accountsettings">
                Account Setting</button></li>
                <li><button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#logout">
                Logout<ion-icon name="log-out-outline"></ion-icon></button></li>
              </ul>
            </div>
          </ul>
        <?php endif; ?>
    </div>
  </div>
</nav>

<script>
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
<script>
  var currentPageUrl = window.location.href;

  function removeSearchForm() {
    var searchForm = document.getElementById('search-form');
    if (searchForm) {
      searchForm.parentNode.removeChild(searchForm);
    }
  }

  if (currentPageUrl !== "http://localhost/E-FarmErce/index.php") {
    removeSearchForm();
  }

  var navLinks = document.querySelectorAll('.nav-link');

  for (var i = 0; i < navLinks.length; i++) {
    var link = navLinks[i];
    if (link.href === currentPageUrl) {
      link.classList.add('active-link');
      break; 
    }
  }
</script>
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content  custom-modal">
      <div class="modal-body">
        <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
        <form action="./extension/login.php" method="POST">
          <h3 class="text-center mt-4" style="color: green;"><b>LOGIN<ion-icon name="log-in-outline"></ion-icon></b></h3>
            <div class="input-group mb-3 mt-4">
              <span class="input-group-text custom-adon" id="username"><ion-icon name="person-outline"></ion-icon></span>
              <input type="text" name="username" class="form-control custom-form" placeholder="Enter Username" aria-label="username" aria-describedby="username" required>
            </div>
            <div class="input-group mb-3 mt-4">
              <span class="input-group-text custom-adon" id="pass"><ion-icon name="lock-closed-outline"></ion-icon></span>
              <input type="password" name="pass" class="form-control custom-form" placeholder="Password" aria-label="pass" aria-describedby="pass" required>
            </div>
            <button type="button" class="btn custom-btn float-end" data-bs-toggle="modal" data-bs-target="#forgotModal" style="font-size: 12px;">forgot pass?</button><br>
            <div class="text-center">
              <br><button class="btn btn-success" name="login" type="submit">log in</button><br>
              <button type="button" class="btn custom-btn" data-bs-toggle="modal" data-bs-target="#registerModal" style="font-size: 12px;">Doesn't have an account?</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
<?php 
  $password = array();
  $forgot = "SELECT number FROM users";
  $resultforgot = mysqli_query($conn, $forgot);

  foreach($resultforgot as $rw){
    $password[] = $rw['number'];
  }
?>

<div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="forgotModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content  custom-modal">
      <div class="modal-body">
        <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
        <form action="" method="POST">
          <h3 class="text-center mt-4" style="color: green;"><b>Recover Account<ion-icon name="construct-outline"></ion-icon></b></h3>
          <div id="alertContainer"></div>
          <div class="input-group mb-3 mt-4">
            <span class="input-group-text custom-adon" id="email"><ion-icon name="person-outline"></ion-icon></span>
            <input type="text" name="email" class="form-control custom-form" placeholder="Contact Number" aria-label="email" aria-describedby="email">
          </div>
          <div class="text-center">
            <br>
            <button class="btn btn-success" name="register" type="submit" id="recoverButton">Recover</button><br>
            <button type="button" class="btn custom-btn" data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size: 12px;">Already have an account?</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>  
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Get the recover button by ID
  var recoverButton = document.getElementById("recoverButton");
  // Get the alert container by ID
  var alertContainer = document.getElementById("alertContainer");

  recoverButton.addEventListener("click", function(e) {
    e.preventDefault();

    // Get the input value
    var phoneNumber = document.querySelector('input[name="email"]').value;

    // Check if the entered number is in the password array
    if (<?php echo json_encode($password); ?>.includes(phoneNumber)) {
      // Create a success alert
      alertContainer.innerHTML = '<div class="alert alert-success" role="alert">Number is in the database!</div>';
      console.log("Redirecting to forgot.php");
      // Redirect to "extension/forgot.php"
      window.location.href = "../extension/forgot.php";
    } else {
      // Create a danger alert
      alertContainer.innerHTML = '<div class="alert alert-danger" role="alert">Number not found in the database!</div>';
    }
  });
});
</script>
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content  custom-modal">
      <div class="modal-body">
        <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
        <h3 class="text-center mt-4" style="color: green;"><b>REGISTER<ion-icon name="person-add-outline"></ion-icon></b></h3>
        <form action="./extension/register.php" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control form-control-sm custom-form" name="username" id="username" required>
            </div>
            <div class="col-md-4 col-sm-4">
              <label for="first_name" class="form-label">First Name</label>
              <input type="text" class="form-control form-control-sm custom-form" name="first_name" id="first_name" required>
            </div>
            <div class="col-md-4 col-sm-4">
              <label for="last_name" class="form-label">Last Name</label>
              <input type="text" class="form-control custom-form form-control-sm" name="last_name" id="last_name" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="new_number" class="form-label">Contact Number</label>
            <input type="text" class="form-control custom-form form-control-sm" name="new_number" id="new_number" placeholder="eg.09150909321" required>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="municipality" class="form-label">Municipality</label>
              <select class="form-control custom-form form-control-sm" name="municipality" id="municipality" required>
                <option value="" disabled selected>Select Municipality</option>
                <?php
                  $query = "SELECT DISTINCT municipality FROM location";
                  $result = mysqli_query($conn, $query);

                  if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='" . $row['municipality'] . "'>" . $row['municipality'] . "</option>";
                    }
                    mysqli_free_result($result);
                  }
                ?>
              </select>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="barangay" class="form-label">Barangay</label>
                <select class="form-control custom-form form-control-sm" name="barangay" id="barangay" required>
                  <option value="" disabled selected>Select Barangay</option>
                  <?php
                    $query = "SELECT barangay_name, municipality FROM location";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['barangay_name'] . "' data-municipality='" . $row['municipality'] . "'>" . $row['barangay_name'] . "</option>";
                      }
                      mysqli_free_result($result);
                    }
                  ?>
                </select>
              </div>
            </div>
          </div>

          <script>
          document.addEventListener("DOMContentLoaded", function () {
            const municipalitySelect = document.getElementById("municipality");
            const barangaySelect = document.getElementById("barangay");

            municipalitySelect.addEventListener("change", function () {
              const selectedMunicipality = municipalitySelect.value;
              barangaySelect.disabled = false;
              for (let i = 0; i < barangaySelect.options.length; i++) {
                const option = barangaySelect.options[i];
                const optionMunicipality = option.getAttribute("data-municipality");
                if (selectedMunicipality === "" || selectedMunicipality === optionMunicipality) {
                  option.style.display = "";
                } else {
                  option.style.display = "none";
                }
              }
            });
          });
          </script>
          <div class="row mb-1">
              <div class="col-md-6 col-sm-6">
                  <label for="n_pass" class="form-label">Password</label>
                  <input type="password" class="form-control form-control-sm custom-form" id="pass1" name="n_pass">
              </div>
              <div class="col-md-6 col-sm-6">
                  <label for="confirm_pass" class="form-label">Confirm Password</label>
                  <input type="password" class="form-control form-control-sm custom-form" id="confirm_pass" name="n_pass">
              </div>
              <span id="passwordMatchMessage"></span>
          </div>
          <div class="row">
          <div class="col-md-12 col-sm-12 mb-3">
            <label for="usertype" class="form-label">Account Type</label>
              <select class="form-control form-control-sm custom-form" aria-label="usertype" name="usertype" id="usertype" required>
                <option value="" disabled selected>Select Account Type</option>
                <option value="Buyer" >Buyer</option>
                <option value="Seller">Seller</option> 
              </select>
            </div>
          </div>
          <div id="pickup_address_input" style="display: none;">
              <div class="input-group mb-3">
                  <span class="input-group-text">Pick Up Address</span>
                  <input type="text" class="form-control" name="pickup_address" placeholder="Enter pick up address">
              </div>
          </div>
          <div id="delivery_address" style="display: none;">
              <div class="input-group mb-3">
                  <span class="input-group-text">Delivery Address</span>
                  <input type="text" class="form-control" name="deliver_add" placeholder="Enter delivery address">
              </div>
          </div>
          <div id="delivery_address_input" style="display: none;">
              <div class="input-group mb-3">
              <span class="input-group-text">Delivery Location Area</span>
              <select class="form-control form-control-sm" name="delivery_location" id="municipality">
                  <option value="" disabled selected>Select Area</option>
                  <?php
                  $query = "SELECT DISTINCT municipality FROM location";
                  $result = mysqli_query($conn, $query);

                  if ($result) {
                      while ($row = mysqli_fetch_assoc($result)) {
                      echo "<option value='" . $row['municipality'] . "'>" . $row['municipality'] . "</option>";
                      }
                      mysqli_free_result($result);
                  }
                  ?>
              </select>
              </div>
          </div>
          <script>
              const modeSelect = document.getElementById("usertype");
              const pickupAddressInput = document.getElementById("pickup_address_input");
              const meetupAddressInput = document.getElementById("delivery_address_input");
              const address = document.getElementById("delivery_address");

              modeSelect.addEventListener("change", function () {
                  const selectedValue = modeSelect.value;

                  if (selectedValue === "Seller") {
                      pickupAddressInput.style.display = "block";
                      meetupAddressInput.style.display = "block";
                  }else if (selectedValue === "Buyer") {
                      address.style.display = "block";
                  }else {
                      pickupAddressInput.style.display = "none";
                      meetupAddressInput.style.display = "none";
                  }
              });
          </script>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="privacyPolicyCheckbox" required>
            <label class="form-check-label" for="privacyPolicyCheckbox">
              I have read and agree to the <a href="#">Privacy Policy</a>
            </label>
          </div>
          <div class="text-center">
            <br><button class="btn btn-success" name="register" type="submit" id="registerButton" disabled>Register</button><br>
            <button type="button" class="btn custom-btn" data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size: 12px;">Already have an account?</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const privacyPolicyCheckbox = document.getElementById("privacyPolicyCheckbox");
    const registerButton = document.getElementById("registerButton");

    privacyPolicyCheckbox.addEventListener("change", function () {
      if (privacyPolicyCheckbox.checked) {
        registerButton.removeAttribute("disabled");
      } else {
        registerButton.setAttribute("disabled", "disabled");
      }
    });
  });
</script>
<script>
    // Get references to the password and confirm password fields
    const passwordField = document.getElementById("pass1");
    const confirmPasswordField = document.getElementById("confirm_pass");
    const passwordMatchMessage = document.getElementById("passwordMatchMessage");

    // Function to check if the passwords match
    function checkPasswordMatch() {
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;

        if (password === confirmPassword) {
            passwordMatchMessage.innerHTML = "Password Match";
            passwordMatchMessage.style.color = "green";
        } else {
            passwordMatchMessage.innerHTML = "Password does not match";
            passwordMatchMessage.style.color = "red";
        }
    }

    passwordField.addEventListener("input", checkPasswordMatch);
    confirmPasswordField.addEventListener("input", checkPasswordMatch);
</script>
<div class="offcanvas offcanvas-end" tabindex="-1" id="notif" aria-labelledby="offcanvasRightLabel1">
    <div class="offcanvas-header">
      <h3 class="text-center" id="offcanvasRightLabel1">NOTIFICATIONS<ion-icon name="notifications-outline"></ion-icon></h3>
    </div>
    <div class="offcanvas-body bg-light">
    <form action="./extension/readAll.php" method="POST">
            <button class="btn float-end" type="submit" name="readAll">Read All</button>
        </form>
    <?php
        $NotifQ = "SELECT * FROM notifications WHERE buyer_id = '$user_id' ORDER BY date_mess DESC";
        $NotifRes = mysqli_query($conn, $NotifQ);

        while($nt = mysqli_fetch_assoc($NotifRes)){
            $message = $nt['message'];
            $date = $nt['date_mess'];
            $stat = $nt['mess_status'];
        ?>
        <form action="./extension/notif.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $nt['notif_id'] ?>">
            <input type="hidden" name="transact" value="<?php echo $nt['transact_code'] ?>">
            <button type="submit" name="read" class="btn">
              <div class="card mb-2" style=" background-color: <?php if($stat == 'Unread'){ echo 'rgb(221, 246, 221);';}else{ echo 'white';} ?>">
                  <div class="card-body">
                      <span><?php echo $date ?></span>
                      <p><?php echo $message ?></p>
                  </div>
              </div>
            </button>
        </form>
    <?php } ?>
    </div>
  </div>
</div>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h3 class="offcanvas-title" id="offcanvasRightLabel">CART<ion-icon name="cart-outline"></ion-icon></h3>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="table">
        <table class="table table-light">
            <thead class="text-center">
                <th></th>
                <th>Product</th>
                <th>Quantity<br>(KG)</th>
                <th>Subtotal</th>
            </thead>
            <?php
              $cart = "SELECT p.*, c.cart_id, c.order_qty
              FROM products p
              INNER JOIN cart c ON p.product_id = c.product_id
              WHERE c.user_id = '{$_SESSION['user_id']}'";
              $cartresult = mysqli_query($conn, $cart);
              $ovtotal = 0;
              foreach ($cartresult as $carts) :
                $productId = $carts['product_id'];
                $productName = $carts['product_name'];
                $productPrice = $carts['product_price'];
                $productStock = $carts['product_stock'];
                $cartId = $carts['cart_id'];
                $quantity = $carts['order_qty'];
                
                $total = $productPrice * $carts['order_qty'];
                $ovtotal += $total;
            ?>
            <tbody class="text-center">
            <tr>
                  <td>
                  <form method="GET">
                        <input type="hidden" name="cart_id" value="<?= $cartId ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                        <button type="submit" name="cart_delete" class="btn btn-light"><ion-icon name="trash-outline"></ion-icon></button>
                  </form>
                  <label>
                      <input type="checkbox" class="btn" name="selected_products[]" value="<?= $cartId ?>" <?php if ($productStock < $carts['min_order'] || $carts['product_status'] == 'Deleted') {echo 'disabled';} else {echo 'checked';} ?>>
                      <?php if ($productStock < $carts['min_order']) {echo 'Stock not enough';}elseif($carts['product_status'] == 'Deleted'){echo 'Unavailable';} ?>
                  </label>
                  </td>
                  <td> <img  style="width: 6em;" src="./images/<?= $carts['product_img'] ?>"><br><?= $productName , ' ' . number_format($productPrice, 2), "<br>" .$productStock . ' kg left' ?></td>
                  <td>
                      <input type="number" name="quantity" class="form-control" value="<?= $quantity ?>" min="<?= $carts['min_order'] ?>" max="<?= $productStock ?>"max="<?= $productStock ?>" disabled>
                  </td>
                  <td><?php echo CURRENCY . number_format($total, 2);?></td>
              </tr>
            <?php endforeach; ?>
            <tr style="background-color: green;">
                <td>TOTAL</td>
                <td></td>
                <td></td>
                <td><?php echo number_format($ovtotal, 2); ?></td>
              </tr>
            </tbody>
        </table>
        <form method="POST" action="./checkout.php" id="checkoutForm">
          <button type="submit" class="btn btn-outline-success text-end" name="checkout">Checkout</button>
        </form>
    </div>
  </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkoutForm = document.querySelector('#checkoutForm');
        const checkboxes = document.querySelectorAll('[name^="selected_products"]');

        checkoutForm.addEventListener('submit', function (event) {
            const selectedCheckboxes = [...checkboxes].filter(checkbox => checkbox.checked);

            if (selectedCheckboxes.length === 0) {
                event.preventDefault(); // Prevent form submission if no checkboxes are selected
                alert('Please select items to checkout.');
            } else {
                // Add selected checkbox values to the checkout form as hidden inputs
                selectedCheckboxes.forEach(checkbox => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'selected_products[]';
                    hiddenInput.value = checkbox.value;
                    checkoutForm.appendChild(hiddenInput);
                });
            }
        });
    });
</script>
<div class="modal fade" id="logout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: black;">LOGOUT</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p style="color: black;">Are you sure you want to log out?</p>
    </div>
    <div class="modal-footer">
      <form action="" method="GET">
        <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-secondary" name="logout">Proceed</button>
      </form>
    </div>
  </div>
</div>
</div>
<!-- <div class="modal fade" id="checkout" tabindex="-1" role="dialog" aria-labelledby="checkout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
              
            </div>
        </div>
    </div>
</div> -->
<?php 
  $infos = "SELECT * FROM users WHERE user_id = '$user_id'";
  $r = mysqli_query($conn, $infos);
  $info = mysqli_fetch_assoc($r);

  if(isset($_POST['changedit'])) {
    $fname = $_POST['n_fullname'];
    $em = $_POST['n_email'];
    $num = $_POST['n_number'];
    $add = $_POST['n_delivery_area'];

    if (!empty($_POST['new_pass'])) {
        $pass = $_POST['new_pass'];
        $enterInfo = "UPDATE users 
                      SET fullname='$fname', email='$em', password='$pass', delivery_area='$add', number='$num'
                      WHERE user_id='$user_id'"; 

    } else {
        $enterInfo = "UPDATE users 
                      SET fullname='$fname', email='$em', delivery_area='$add', number='$num'
                      WHERE user_id='$user_id'";
    }

    if (mysqli_query($conn, $enterInfo)) {
      // Set a JavaScript variable to indicate success
      echo "<script>var successMessage = 'User information updated successfully!';</script>";
  } else {
      echo "Error updating user information: " . mysqli_error($conn);
  }
  
}
?>
<div class="modal fade" id="accountsettings" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <div class="modal-body">
        <b><h3 class="bg-light text-center" style="color: green;">ACCOUNT SETTINGS<ion-icon name="cog-outline"></ion-icon></h3></b>
        <span id="success_message" class="text-success"></span>
          <h5 class="text-center bg-light">ACCOUNT DETAILS</h5>
          <button class="btn float-end mt-4" data-bs-target="#edit" data-bs-toggle="modal">Edit</button>
          <div class="row text-center">
            <div class="col-5 border-end">ORDER TOTAL: <?php echo $count2 ?></div>
            <div class="col-7 border-start">TOTAL SPEND: <?php echo CURRENCY . number_format( $total_order, 2) ?></div>
          </div>
          <div class="input-group input-group-sm mb-3 mt-2">
              <span class="input-group-text">NAME</span>
              <input type="readonly" class="form-control" name="fullname" value="<?php echo $info['fullname'] ?>" readonly>
          </div>
          <div class="input-group input-group-sm mb-3">
              <span class="input-group-text">EMAIL</span>
              <input type="readonly" class="form-control" name="email" value="<?php echo $info['email'] ?>" readonly>
          </div>
          <div class="input-group input-group-sm mb-3">
              <span class="input-group-text">CONTACT NUMBER</span>
              <input type="readonly" class="form-control" name="number" value="<?php echo $info['number'] ?>" readonly>
          </div>
          <div class="input-group input-group-sm mb-3">
              <span class="input-group-text">ADDRESS</span>
              <input type="readonly" class="form-control" name="number" value="<?php echo $info['address'] ?>" readonly>
          </div>
          <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">DELIVERY ADDRESS</span>
                <input type="text" class="form-control" name="number" value="<?php echo $info['delivery_area'] ?>" readonly>
            </div>
      </div>
    </div>
  </div>
</div>
<script>
  
  if (typeof successMessage !== 'undefined') {

    var successMessageSpan = document.getElementById('success_message');
    successMessageSpan.textContent = successMessage;

    $('#accountsettings').modal('show');
  }
</script>
<div class="modal fade" id="edit" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <b><h3 class="bg-light text-center" style="color: green;">ACCOUNT SETTINGS<ion-icon name="cog-outline"></ion-icon></h3></b>
          <h5 class="text-center bg-light">EDIT ACCOUNT</h5>
          <button class="btn float-end" data-bs-target="#accountsettings" data-bs-toggle="modal">Cancel</button>
          <form method="POST">
          <div class="input-group input-group-sm mb-3 mt-2">
              <span class="input-group-text">NAME</span>
              <input type="text" class="form-control" name="n_fullname" value="<?php echo $info['fullname'] ?>">
          </div>
          <div class="input-group input-group-sm  mb-3">
              <span class="input-group-text">EMAIL</span>
              <input type="text" class="form-control" name="n_email" value="<?php echo $info['email'] ?>">
          </div>
          <div class="input-group input-group-sm  mb-3">
              <span class="input-group-text">CONTACT NUMBER</span>
              <input type="text" class="form-control" name="n_number" value="<?php echo $info['number'] ?>">
          </div>
          <div class="input-group input-group-sm mb-3">
              <span class="input-group-text">DELIVERY ADDRESS</span>
              <input type="text" class="form-control" name="n_delivery_area" value="<?php echo $info['delivery_area'] ?>">
          </div>
          <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#pass" aria-expanded="false" aria-controls="collapseExample">
            CHANGE PASSWORD
          </button>
          <div class="collapse" id="pass">
            <div class="card card-body">
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">OLD PASSWORD</span>
                <input type="password" class="form-control" name="old_pass" id="old_pass" placeholder="Enter your old password">
              </div>
              <span id="password_mismatch_msg" class="text-danger"></span>
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">ENTER YOUR NEW PASSWORD</span>
                <input type="password" class="form-control" name="new_pass" id="new_pass" placeholder="Enter your new password" disabled>
              </div>
            </div>
          </div>
          <div class="text-center mt-3">
            <button class="btn btn-outline-success" name="changedit" type="submit">Submit</button>
          </form>
          </div>
      </div>
    </div>
  </div>
</div>
<script>
 // Get references to the input elements and the error message span
const oldPassInput = document.getElementById("old_pass");
const oldPasswordFromDatabase = "<?php echo $info['password']; ?>";
const newPasswordInput = document.getElementById("new_pass");
const passwordMismatchMsg = document.getElementById("password_mismatch_msg");

// Add an event listener to the old_pass input for input changes
oldPassInput.addEventListener("input", function () {
  // Check if the entered old password matches the one from the database
  if (oldPassInput.value === oldPasswordFromDatabase) {
    // Passwords match, enable the new_pass input and clear the error message
    newPasswordInput.removeAttribute("disabled");
    passwordMismatchMsg.textContent = "";
  } else {
    // Passwords don't match, disable the new_pass input and display the error message
    newPasswordInput.setAttribute("disabled", "disabled");
    passwordMismatchMsg.textContent = "Old password does not match!";
  }
});


</script>

    