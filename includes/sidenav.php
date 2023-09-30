<?php 
  require_once 'db.php';
  $user_id = $_SESSION['user_id'];

?>
<aside>
    <div class="sidebar">
      <div class="top">
        <div class="logo">
            <i><ion-icon name="storefront-outline"></ion-icon></i>
          <span>E-FarmErce</span>
        </div>
        <i id="btn"><ion-icon name="menu-outline"></ion-icon></i>
      </div>
      <ul>
        <?php 
          $que = "SELECT user_type FROM users WHERE user_id = '$user_id'";
          $q = mysqli_query($conn, $que);
          $r = mysqli_fetch_assoc($q);
          $w = $r['user_type'];
          if($w == 'Admin'){ ?>
          <li>
            <a href="admin.php" class="nav-item1">
              <i><ion-icon name="grid-outline"></ion-icon></i>
              <span class="nav-item">Dashboard</span>
            </a>
          </li>
          <li>
            <a href="productlist.php" class="nav-item1">
              <i><ion-icon name="nutrition-outline"></ion-icon></i>
              <span class="nav-item">Inventory</span>
            </a>
          </li>
          <li>
            <a href="acc_management.php" class="nav-item1">
            <i><ion-icon name="people-circle-outline"></ion-icon></i>
              <span class="nav-item">Accounts</span>
            </a>
          </li>
          <li>
            <a href="./index.php" class="nav-item1 my-5" data-bs-toggle="tooltip" data-bs-title="BACK HOME">
              <i><ion-icon name="swap-horizontal-outline"></ion-icon></i>
              <span class="nav-item">HOME</span>
            </a>
          </li>
        <?php } else{ ?>
          <li>
          <a href="seller.php" class="nav-item1">
            <i><ion-icon name="grid-outline"></ion-icon></i>
            <span class="nav-item">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="inventory.php" class="nav-item1">
           <i><ion-icon name="bag-add-outline"></ion-icon></i>
            <span class="nav-item">Inventory</span>
          </a>
        </li>
        <li>
          <a href="seller_orders.php" class="nav-item1">
           <i><ion-icon name="bag-check-outline"></ion-icon></i>
            <span class="nav-item">OrderList</span>
          </a>
        </li>
        <li>
          <a href="./index.php" class="nav-item1 my-5" data-bs-toggle="tooltip" data-bs-title="BACK HOME">
            <i><ion-icon name="swap-horizontal-outline"></ion-icon></i>
            <span class="nav-item">SWITCH</span>
          </a>
        </li>
        <?php } ?>
      </ul>
    </div>
  </aside>
<script>
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
  <script>
    const currentURL = window.location.href;
    const navLinks = document.querySelectorAll('.nav-item1');

    navLinks.forEach(link => {
      const linkURL = link.getAttribute('href');
      
      if (currentURL.includes(linkURL)) {
        link.classList.add('active'); 
      }
    });

    // Toggle sidebar functionality (unchanged)
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');

    btn.onclick = function () {
      sidebar.classList.toggle('active');
    };
  </script>

<style>
    <?php include_once './css/side.css';?>
</style>