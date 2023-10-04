<?php
    require_once 'db_conn.php';
    
    require 'phpmailer\src\PHPMailer.php';
    require 'phpmailer\src\SMTP.php';
    require 'phpmailer\src\Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if(isset($_POST['resetpass'])) {
        $email = $_POST['r_email'];

        $sql = "SELECT * FROM users WHERE user_email='$email'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];

            $confirmationCode = generateConfirmationCode();

            $updateSql = "UPDATE users SET reset_confirmation_code='$confirmationCode' WHERE user_id='$user_id'";
            mysqli_query($conn, $updateSql);

            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'renzranoco12@gmail.com';
                $mail->Password = 'Trenderoxertrumplets122112';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                // Email content
                $mail->setFrom('renzranoco12@gmail.com', 'NCI');
                $mail->addAddress($email);
                $mail->Subject = 'Reset Password Confirmation Code';
                $mail->Body = 'Your confirmation code is: ' . $confirmationCode;

                // Send the email
                $mail->send();

                echo "<script>alert('Confirmation code has been sent to your email.');</script>";
                header("Location: user_forgotpass_process.php?user_id=$user_id");
                exit();
            } catch (Exception $e) {
                echo "<script>alert('Failed to send confirmation code. Error: " . $mail->ErrorInfo . "');</script>";
                exit();
            }
        } else {
            echo "<script>alert('You entered a non-existing contact number and email. Please try again.');</script>";
            header("Location: user_forgotpass.php");
            exit();
        }
    }


    if(isset($_POST['change_pass'])){
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $user_id = $_POST['user_id'];
    
        // Check if the new password and confirm password match
        if ($new_password !== $confirm_password) {
            echo "<script>alert('New password and confirm password do not match...')</script>";
            header("location: user_forgotpass_process.php?error=passwordMismatch");
            exit();
        }
    
        // Fetch user details from database
        $user = "SELECT * FROM users WHERE user_id = '$user_id'";
        $result1 = mysqli_query($conn, $user);
        if (mysqli_num_rows($result1) > 0) {
            $row = mysqli_fetch_assoc($result1);
    
            $query = "UPDATE users SET password='$new_encryptpassword', private_key='$private_key' WHERE user_id=$user_id";
            $result2 = mysqli_query($conn, $query);
    
            if ($result2) {
                echo "<script>alert('Password successfully changed. You will be redirected to login page in 1 second.')</script>";
                header("refresh:1;url=visitor_login.php");
                exit(); 
            } else {
                echo "Error changing password: " . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('User not found.')</script>";
        }
    }    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- <link rel="stylesheet" href="user_home.css"> -->
    <!-- <link rel="stylesheet" href="bootstrap.css"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card{
            width: 60em;
            height: 35em;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .reset_form {
            padding: 5em;
        }
        a{
            font-family: 'Arial Narrow';
            font-size: small;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div id="carouselAuto" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="./img/img2.jpg" class="d-block w-100" width="100%" height="525" alt="\La Nelle 3.jpg">
                            </div>
                            <div class="carousel-item">
                                <img src="./img/img2.jpg" class="d-block w-100" width="1000" height="525" alt="/La Nelle 1.jpg">
                            </div>
                            <div class="carousel-item">
                                <img src="./img/img2.jpg" class="d-block w-100" width="1000" height="525" alt="C:\Users\krizi\Desktop\Leno\La Nelle 2.jpg">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 reset_form">
                    <form method="POST" action="">
                        <input type="hidden" name="user_id" value="<?php echo $user_id?>">
                        <h5>HI USER!</h5>
                        <p><i>Only a few steps remain to reclaim your account. :)</i></p>
                        <?php 
                            $query = "SELECT reset_confirmation_code FROM users WHERE user_id = '$user_id'";
                            $reset_confirmation_code = mysqli_fetch_assoc(mysqli_query($conn, $query))['reset_confirmation_code'];

                            if($reset_confirmation_code != 'NULL'):
                        ?>
                        <p>CODE VERIFICATION</p>
                        <div class="form-floating mb-3">
                            <input type="confirm_code" class="form-control" id="floatingInput" placeholder="Enter the code" name="confirm_code" required>
                            <label for="floatingInput">Enter the Confirmation Code</label>
                        </div>
                        <?php else: ?>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingInput" placeholder="Enter a username" name="new_password" required>
                            <label for="floatingInput">Enter your new Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="confirm_password" required>
                            <label for="floatingPassword">Confirm your password</label>
                        </div>
                        <button type="submit" class="btn btn-secondary" name="change_pass">SUBMIT</button><br>
                        <a href="landingpage.php">Already remembered your password?</a>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>