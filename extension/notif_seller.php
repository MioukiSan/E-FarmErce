<button type="button"style=" color: green;" class="btn position-relative m-2" data-bs-toggle="offcanvas" data-bs-target="#notif" aria-controls="offcanvasRight">
<ion-icon size="large" name="notifications-outline"></ion-icon>
<?php   
    $query2 = "SELECT COUNT(*) AS count1 FROM seller_notif WHERE seller_id = '$user_id' AND notif_sts = 'Unread'";
    $res1 = mysqli_query($conn, $query2);
    $row2 = mysqli_fetch_assoc($res1);
    $count1 = $row2['count1'];
    if($count1 != 0){ ?>
    <span class="position-absolute top-40 start-170 translate-middle p-1 bg-danger border border-light rounded-circle">
        <span class="visually-hidden">New alerts</span>
    </span>
<?php } else{} ?>
</button>
<div class="offcanvas offcanvas-end" tabindex="-1" id="notif" aria-labelledby="offcanvasRightLabel1">
    <div class="offcanvas-header">
      <h3 class="text-center" id="offcanvasRightLabel1">NOTIFICATIONS<ion-icon name="notifications-outline"></ion-icon></h3>
    </div>
    <div class="offcanvas-body bg-light">
        <div class="row">
            <form action="./extension/read.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $user_id ?>">
                <button class="btn float-end" type="submit" name="readAll">Read All</button>
            </form>
        </div>
    <?php
        $NotifSl = "SELECT * FROM seller_notif WHERE seller_id = '$user_id' ORDER BY notif_date DESC";
        $NotifSLRes = mysqli_query($conn, $NotifSl);

        while($nt = mysqli_fetch_assoc($NotifSLRes)){
            $message = $nt['not_info'];
            $date = $nt['notif_date'];
            $stat = $nt['notif_sts'];

        if(is_null($nt['transact_code'])){
        ?>
        <div class="card mb-2" style=" background-color: <?php if($stat == 'Unread'){ echo 'rgb(221, 246, 221);';}else{ echo 'white';} ?>">
            <div class="card-body">
                <span><?php echo $date ?></span>
                <p><?php echo $message ?></p>
            </div>
        </div>
        <?php } else{ ?>
        <form action="extension\seller_notif_update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $nt['notif_seller_id'] ?>">
            <input type="hidden" name="transact" value="<?php echo $nt['transact_code'] ?>">
            <button type="submit" name="read" class="btn">
              <div class="card mb-2" style=" background-color: <?php if($stat == 'Unread'){ echo 'rgb(221, 246, 221);';}else{ echo 'white';} ?>">
                  <div class="card-body">
                      <span><?php echo $date ?></span>
                      <p><?php echo $message ?></p>
                  </div>
              </div>
            </button>
            <?php } ?>
        </form>
    <?php } ?>
    </div>
  </div>