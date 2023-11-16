<?php
require_once '../includes/db.php';

if (isset($_POST['change_status'])) {
    $status = $_POST['status'];
    $stat = $_POST['def_stat'];
    $mess = $_POST['message'];
    $number = $_POST['number'];
    $transact = $_POST['transact'];
    $ref = $_POST['order_ref'];

    if ($transact == 'Pick Up') {
        if ($stat == 'Pending') {
            $date = $_POST['date'] . '-' . $_POST['time'];
            $messdate = $mess . ' Date of Transaction: ' . $date;

            $buyer_id = $_POST['buyer_id'];
            $seller_id = $_POST['seller_id'];

            $sqlNotif = "INSERT INTO notifications (seller_id, buyer_id, message, transact_code) VALUES (?, ?, ?, ?)";
            $stmtNotif = $conn->prepare($sqlNotif);
            $stmtNotif->bind_param("iiss", $seller_id, $buyer_id, $mess, $ref);

                $ch = curl_init();
                $parameters = array(
                    'apikey' => 'a98eb9abe2636f1d3c09370d98663a40',
                    'number' => $number,
                    'message' => $messdate,
                    'sendername' => 'EFarmErce'
                );

                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $output = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'CURL Error: ' . curl_error($ch);
                } else {
                    $stmt = $conn->prepare("UPDATE orders SET order_status = ?, order_delivery_date = ? WHERE order_reference = ?");
                    $stmt->bind_param("sss", $status, $date, $ref);

                    if ($stmt->execute()) {
                        echo "<script>alert('Changed SUCCESSFULLY'); window.location.href = document.referrer;</script>";
                    } else {
                        echo "Error updating order: " . mysqli_error($conn);
                    }
                }

                curl_close($ch);
        } else {
            $buyer_id = $_POST['buyer_id'];
            $seller_id = $_POST['seller_id'];
            $sqlNotif = "INSERT INTO notifications (seller_id, buyer_id, message, transact_code) VALUES (?, ?, ?, ?)";
            $stmtNotif = $conn->prepare($sqlNotif);
            $stmtNotif->bind_param("iiss", $seller_id, $buyer_id, $mess, $ref);

                // Send SMS message after inserting the notification
                $ch = curl_init();
                $parameters = array(
                    'apikey' => 'a98eb9abe2636f1d3c09370d98663a40',
                    'number' => $number,
                    'message' => $mess,
                    'sendername' => 'EFarmErce'
                );

                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $output = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'CURL Error: ' . curl_error($ch);
                } else {
                    // Update orders row after sending SMS
                    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_reference = ?");
                    $stmt->bind_param("ss", $status, $ref);

                    if ($stmt->execute()) {
                        echo "<script>alert('Changed SUCCESSFULLY'); window.location.href = document.referrer;</script>";
                    } else {
                        echo "Error updating order: " . mysqli_error($conn);
                    }
                }                    

                curl_close($ch);
        }
    } elseif ($transact == 'Deliver') {
        if ($stat == 'Pending') {
            $date = $_POST['date'];
            $messdate = $mess . ' Date of Transaction: ' . $date;

            // Insert notification first
            $buyer_id = $_POST['buyer_id'];
            $seller_id = $_POST['seller_id'];

            $sqlNotif = "INSERT INTO notifications (seller_id, buyer_id, message, transact_code) VALUES (?, ?, ?, ?)";
            $stmtNotif = $conn->prepare($sqlNotif);
            $stmtNotif->bind_param("iiss", $seller_id, $buyer_id, $messdate, $ref);

                $ch = curl_init();
                $parameters = array(
                    'apikey' => 'a98eb9abe2636f1d3c09370d98663a40',
                    'number' => $number,
                    'message' => $messdate,
                    'sendername' => 'EFarmErce'
                );

                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $output = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'CURL Error: ' . curl_error($ch);
                } else {
                    // Update orders row after sending SMS
                    $stmt = $conn->prepare("UPDATE orders SET order_status = ?, order_delivery_date = ? WHERE order_reference = ?");
                    $stmt->bind_param("sss", $status, $date, $ref);

                    if ($stmt->execute()) {
                        echo "<script>alert('Changed SUCCESSFULLY'); window.location.href = document.referrer;</script>";
                    } else {
                        echo "Error updating order: " . mysqli_error($conn);
                    }
                }

                curl_close($ch);
        } else {
            $sqlNotif = "INSERT INTO notifications (seller_id, buyer_id, message, transact_code) VALUES (?, ?, ?, ?)";
            $stmtNotif = $conn->prepare($sqlNotif);
            $stmtNotif->bind_param("iiss", $seller_id, $buyer_id, $messdate, $ref);

                $ch = curl_init();
                $parameters = array(
                    'apikey' => 'a98eb9abe2636f1d3c09370d98663a40',
                    'number' => $number,
                    'message' => $mess,
                    'sendername' => 'EFarmErce'
                );

                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $output = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'CURL Error: ' . curl_error($ch);
                } else {
                    // Update orders row after sending SMS
                    $stmt = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_reference = ?");
                    $stmt->bind_param("ss", $status, $ref);

                    if ($stmt->execute()) {
                        echo "<script>alert('Changed SUCCESSFULLY!'); window.location.href = document.referrer;</script>";
                    } else {
                        echo "Error updating order: " . mysqli_error($conn);
                    }
                }

                curl_close($ch);
        }
    }
}
?>
