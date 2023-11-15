<?php
require_once '../includes/db.php';

if (isset($_POST['register'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $number = $_POST['new_number'];
    $municipality = $_POST['municipality'];
    $barangay = $_POST['barangay'];
    $password = $_POST['n_pass'];
    $user_type = $_POST['usertype'];
    $username = $_POST['username'];

    $check_query = "SELECT * FROM users WHERE number = '$number'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "Number is already used. Please choose a different email or number.";
        exit;
    }

    // Insert user data into the database
    $fullname = $first_name . ' ' . $last_name;
    $address = $barangay . ',' . $municipality;

    $pickup_address = '';
    $delivery_location = '';
    $sts = 'Verified';

    if ($user_type == "Seller") {
        $pickup_address = $_POST['pickup_address'];
        $delivery_location = $_POST['delivery_location'];
        $sql = "INSERT INTO users (username, password, fullname, number, address, user_type, pickup_address, delivery_area, sts) 
        VALUES ('$username', '$password', '$fullname', '$number', '$address', '$user_type','$pickup_address', '$delivery_location', '$sts')";
    }else{
        $delivery_location = $_POST['deliver_add'];
        $sql = "INSERT INTO users (username, password, fullname, number, address, municipality, user_type,delivery_area, sts) 
        VALUES ('$username', '$password', '$fullname', '$number', '$address', '$municipality', '$user_type','$delivery_location', '$sts')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registered Successfully! Login to Confirm your account.'); window.location.href = document.referrer;</script>";
        exit; // Terminate the script after redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
