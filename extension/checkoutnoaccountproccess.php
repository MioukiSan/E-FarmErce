<?php
    require_once '../includes/db.php';

    if(isset($_POST['checkout_no_acc'])){
        $name = $_SESSION['name'];
        $address = $_SESSION['address'];
        $municipality = $_SESSION['municipality'];
        $selectedMode = $_SESSION['transaction_mode'];
        $number = $_SESSION['number'];
        
        // $check_query = "SELECT * FROM users WHERE number = '$number'";
        // $check_result = $conn->query($check_query);

        // if ($check_result->num_rows > 0) {
        // echo "<script>alert('Number already in used. Enter another number to make have a contact with you.'); window.location.href = document.referrer;</script>";
        // exit;
        // }
        $strongPassword = generateStrongPassword();
        $orderRef = generateOrderReference(10);
        $sts = 'Active';
        $user_type = 'Buyer';
        $msgbuyer = 'If you want to visit the store and check your order, here is username and password. USERNAME: ' . $number . ' PASSWORD: ' . $strongPassword . ' .Dont share this to others.';
        $sql = "INSERT INTO users (username, password, fullname, number, address, municipality, user_type,delivery_area, sts) 
        VALUES ('$number', '$strongPassword', '$name', '$number', '$address', '$municipality', '$user_type','$address', '$sts')";

        if ($conn->query($sql) === TRUE) {
            $productId = $_SESSION['product_id'];
            $qty = $_SESSION['qty'];

            // Retrieve user information
            $getUserQuery = "SELECT user_id, username FROM users WHERE username = '$number'";
            $userResult = mysqli_query($conn, $getUserQuery);
            $userRow = mysqli_fetch_assoc($userResult);

            $user_id = $userRow['user_id'];

            // Retrieve product information
            $getProductQuery = "SELECT seller_id, product_price FROM products WHERE product_id = '$productId'";
            $productResult = mysqli_query($conn, $getProductQuery);
            $productRow = mysqli_fetch_assoc($productResult);

            $sellerId = $productRow['seller_id'];
            $productPrice = $productRow['product_price'];

            $subtotal = $productRow['product_price'] * $qty;
            
            $insertOrderQuery = "INSERT INTO orders (user_id, seller_id, order_reference, product_id, order_qty, order_status, order_total, date_place, transact_mode)
            VALUES ('$user_id', '$sellerId', '$orderRef', '$productId', '$qty', 'Pending', '$subtotal', NOW(), '$selectedMode')";
            $insertResult = mysqli_query($conn, $insertOrderQuery);

            if ($insertResult) {
            // Successfully inserted order, now subtract order_qty from product_stock
            $updateStockQuery = "UPDATE products SET product_stock = product_stock - $qty WHERE product_id = '$productId'";
            mysqli_query($conn, $updateStockQuery);

            $notifInfo = "Your products with transact order " . $orderRef . " have been checked out with total of " . CURRENCY . number_format($subtotal, 2) . ".";
            $insertNotifQuery = "INSERT INTO seller_notif (seller_id, not_info, transact_code, product_id)
                    VALUES ('$sellerId', '$notifInfo', '$orderRef', $productId)";
            mysqli_query($conn, $insertNotifQuery);
            
            $insertMessage = "INSERT INTO messages (outgoing_msg_id, incoming_msg_id, msg)
                VALUES ('$sellerId', '$user_id', '$notifInfo')";
                mysqli_query($conn, $insertMessage);
                
                $ch = curl_init();
                $parameters = array(
                    'apikey' => 'a98eb9abe2636f1d3c09370d98663a40',
                    'number' => $number,
                    'message' => $notifInfo . $msgbuyer,
                    'sendername' => 'EFarmErce'
                );
                curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
                curl_setopt( $ch, CURLOPT_POST, 1 );

                //Send the parameters set above with the request
                curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

                // Receive response from server
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                $output = curl_exec( $ch );
                curl_close ($ch);

                //Show the server response
                echo $output;

            } else {
            echo "Error inserting order data.";
            }    
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Update</title>
</head>
<body>
    <form action="login.php" method="POST" id="updateForm">
        <input type="hidden" name="username" value="<?php echo $number ?>">
        <input type="hidden" name="pass" value="<?php echo $strongPassword ?>">
        <input type="hidden" name="login" value="1">
    </form>
    <script>
        document.getElementById('updateForm').submit();
    </script>
</body>
</html>


