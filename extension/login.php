<?php
require_once '../includes/db.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['pass'];

    // Validate input (you can add more validation as needed)
    if (empty($username) || empty($password)) {
        echo "Email and password are required.";
    } else {
        // Check if the email exists in the database
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];
            $user_type = $row['user_type'];
            $_SESSION['user_id'] = $row['user_id'];

            // Compare the provided password to the stored password
            if ($password === $stored_password) {
                $user_id = $row['user_id'];
                $user_sts = $row['sts']; // Get the user's status

                // Check if the user's status is 'Unverified'
                if ($user_sts === 'Unverified') {
                    $confirmationCode = generateConfirmationCode();
                    
                    // Update the confirmation code in the database
                    $updateSql = "UPDATE users SET forgot_code = '$confirmationCode' WHERE user_id='$user_id'";
                    $conn->query($updateSql);

                    $mail = new PHPMailer(true);

                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'renznormanranoco.palma@bicol-u.edu.ph';
                        $mail->Password = 'gxitjdtoxpavqgwi';
                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = 465;

                        // Email content
                        $mail->setFrom('renzranoco12@gmail.com', 'NCI');
                        $mail->addAddress($email);
                        $mail->Subject = 'Reset Password Confirmation Code';
                        $mail->Body = 'Your confirmation code is: ' . $confirmationCode;

                        // Send the email
                        $mail->send();
                    } catch (Exception $e) {
                        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        exit();
                    }
                    $_SESSION['user_id'] = $user_id;
                    header("location: ../account_confirm.php");
                    exit();
                }

                // Update the last login time
                $update_last_login_sql = "UPDATE users SET last_login = NOW() WHERE user_id = '$user_id'";
                $conn->query($update_last_login_sql);

                $_SESSION['username'] = $row['username'];
                $_SESSION['fullname'] = $row['fullname'];
                $_SESSION['user_type'] = $user_type;

                $_SESSION['login_status'] = 'success';
                if ($user_type === 'Admin') {
                    header("location: ../dashboard_admin.php");
                } elseif ($user_type === 'Seller') {
                    header("location: ../seller.php");
                } elseif ($user_type === 'Buyer') {
                    header("location: ../index.php");
                } else {
                    echo "Unknown user type. Please contact the administrator.";
                }
                exit();
            } else {
                $_SESSION['login_status'] = 'error';
                echo '<script>alert("Incorrect password. Please try again.")</script>';
                header("location: ../index.php");
                exit;
            }
        } else {
            $_SESSION['login_status'] = 'error';
            echo '<script>alert("Email not found. Register first.")</script>';
            header("location: ../index.php");
            exit();
        }
    }
}
?>
