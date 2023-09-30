<?php
require_once '../includes/db.php';

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $number = $_POST['new_number'];
    $municipality = $_POST['municipality'];
    $barangay = $_POST['barangay'];
    $password = $_POST['n_pass'];
    $user_type = $_POST['usertype'];

    // Hash the password

    // File upload for valid ID
    $valid_id_dir = '../images/';
    $valid_id_name = basename($_FILES["id_image"]["name"]);
    $valid_id_path = $valid_id_dir . $valid_id_name;

    if (empty($_FILES["id_image"]["name"])) {
        echo "Please upload a valid ID image.";
        exit;
    }

    // Check if the uploaded file is an image
    $valid_id_file_type = strtolower(pathinfo($valid_id_path, PATHINFO_EXTENSION));
    if (!in_array($valid_id_file_type, array('jpg', 'jpeg', 'png', 'gif'))) {
        echo "Only JPG, JPEG, PNG, and GIF files are allowed for the valid ID image.";
        exit;
    }

    // Move the uploaded image to the destination folder
    if (!move_uploaded_file($_FILES["id_image"]["tmp_name"], $valid_id_path)) {
        echo "Valid ID image upload failed.";
        exit;
    }

    // File upload for selfie with valid ID
    $selfie_id_dir = '../images/';
    $selfie_id_name = basename($_FILES["id_image_withuser"]["name"]);
    $selfie_id_path = $selfie_id_dir . $selfie_id_name;

    if (empty($_FILES["id_image_withuser"]["name"])) {
        echo "Please upload a selfie with a valid ID image.";
        exit;
    }

    // Check if the uploaded file is an image
    $selfie_id_file_type = strtolower(pathinfo($selfie_id_path, PATHINFO_EXTENSION));
    if (!in_array($selfie_id_file_type, array('jpg', 'jpeg', 'png', 'gif'))) {
        echo "Only JPG, JPEG, PNG, and GIF files are allowed for the selfie with valid ID image.";
        exit;
    }

    // Move the uploaded image to the destination folder
    if (!move_uploaded_file($_FILES["id_image_withuser"]["tmp_name"], $selfie_id_path)) {
        echo "Selfie with valid ID image upload failed.";
        exit;
    }

    // Check if the email or number is already used
    $check_query = "SELECT * FROM users WHERE email = '$email' OR number = '$number'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "Email or number is already used. Please choose a different email or number.";
        exit;
    }

    // Insert user data into the database
    $fullname = $first_name . ' ' . $last_name;
    $address = $barangay . ',' . $municipality;

    $pickup_address = '';
    $delivery_location = '';

    if ($user_type == "Seller") {
        $pickup_address = $_POST['pickup_address'];
        $delivery_location = $_POST['delivery_location'];
        $sql = "INSERT INTO users (email, password, fullname, number, address, user_type, id_img, selfie_id, pickup_address, delivery_area) 
        VALUES ('$email', '$password', '$fullname', '$number', '$address', '$user_type', '$valid_id_name', '$selfie_id_name', '$pickup_address', '$delivery_location')";
    }else{
        $delivery_location = $_POST['deliver_add'];
        $sql = "INSERT INTO users (email, password, fullname, number, address, municipality, user_type, id_img, selfie_id, delivery_area) 
        VALUES ('$email', '$password', '$fullname', '$number', '$address', '$municipality', '$user_type', '$valid_id_name', '$selfie_id_name', '$delivery_location')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registered Successfully! LOGIN'); window.location.href = document.referrer;</script>";
        exit; // Terminate the script after redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
