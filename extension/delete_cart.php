<?php
    require_once '../includes/db.php';

    $user_id = $_GET['user_id'];
    $cartId = $_GET['cart_id'];

    $sql = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $cartId, $user_id);

        if ($stmt->execute()) {
            // Redirect back to the previous page
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "Error deleting cart item: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Error: Statement preparation failed.";
    }

    // Output should come after header() to avoid "headers already sent" warning
    echo "Cart item deleted successfully";
    echo "<script>
            document.getElementById('offcanvasright').classList.add('show');
          </script>";
?>
