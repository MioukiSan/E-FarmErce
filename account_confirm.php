<?php
require_once './includes/db.php';

if (isset($_POST['confirm'])) {
    $user_id = $_POST['user_id'];
    $enteredCode = $_POST['confirmation_code'];

    // Validate input (you can add more validation as needed)
    if (empty($enteredCode)) {
        echo "<script>alert('Please enter the confirmation code.');</script>";
        exit();
    }

    // Check if the entered code matches the stored code
    $sql = "SELECT * FROM users WHERE user_id = '$user_id' AND forgot_code = '$enteredCode'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $updateSql = "UPDATE users SET sts = 'Active' WHERE user_id='$user_id'";
        mysqli_query($conn, $updateSql);

        echo "<script>alert('Confirmation successful!');</script>";
        // Redirect the user to another page after successful confirmation
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Incorrect confirmation code. Please try again.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Account</title>
    <?php require_once './includes/head.php'; ?>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card" style="margin-top: 8em; width: 60em;">
                <div class="row">
                    <div class="col-md-6 my-3">
                        <div id="slide" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active" data-bs-interval="5000">
                                    <img src="./images/product1.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="./images/product2.jpg" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="./images/product3.jpg" class="d-block w-100" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 my-3 reset_form">
                        <form method="POST" action="">
                            <input type="hidden" name="user_id" value="<?php echo $user_id?>">
                            <h5>HI USER!</h5>
                            <p><i>Only a few steps remain to enjoy shopping. :)</i></p>
                            <div class="alert alert-info" role="alert">
                                We already send a confirmation code on your email.Please check your inbox!!!
                            </div>
                            <label for="confirmcode">ENTER CONFIRMATION CODE</label>
                            <input type="text" class="form-control mt-2" name="confirmation code">
                            <button class="btn btn-success mt-4" type="submit" name="confirm">SUBMIT</button>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</body>
</html>