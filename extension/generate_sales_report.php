<?php
require('../fpdf/FPDF.php');
require_once '../includes/db.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['view'])) {
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $queryO = "SELECT * FROM orders WHERE DATE(date_place) BETWEEN '$start' AND '$end' AND seller_id = '$user_id'";
    $queryR = mysqli_query($conn, $queryO);
} else {
    $this_date = $_POST['this_date'];
    $queryO = "SELECT * FROM orders WHERE DATE(date_place) = '$this_date' AND seller_id = '$user_id'";
    $queryR = mysqli_query($conn, $queryO);
}

// Check if there are order records
if ($queryR) {
    // Initialize PDF
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('Arial', 'B', 10);

    // Header
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->Cell(0, 5, 'E-FarmErce', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 5, 'Sales Report', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    if (isset($_POST['view'])) {
    $pdf->Cell(0, 5, $start . ' - ' . $end, 0, 1, 'C');
    } else {
        $pdf->Cell(0, 5, 'DATE: ' . $this_date, 0, 1, 'C');
    }
    $pdf->Ln(5);

    // Table header
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(52, 162, 192);
    $pdf->Cell(45, 10, 'ORDER REF.', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'PRODUCT', 1, 0, 'C', true);
    $pdf->Cell(55, 10, 'ORDER DETAILS', 1, 0, 'C', true);
    $pdf->Cell(50, 10, 'BUYER', 1, 1, 'C', true);

    $pdf->SetFillColor(52, 162, 192);
    $pdf->SetFont('Arial', '', 10);

    while ($orderInfoRow = mysqli_fetch_assoc($queryR)) {
        $product_id = $orderInfoRow['product_id'];
    
        // Fetch product information using a prepared statement
        $queryInfoProd = "SELECT * FROM products WHERE product_id = ?";
        $stmt = mysqli_prepare($conn, $queryInfoProd);
        mysqli_stmt_bind_param($stmt, 's', $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
    

        $pdf->Cell(45, 10, $orderInfoRow['order_reference'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['product_name'], 1, 0, 'C');
        $pdf->Cell(55, 10, 'ORDER QTY: ' . $orderInfoRow['order_qty'] . "\n" . 'ORDER TOTAL: ' . $orderInfoRow['order_total'], 1, 0, 'C');
        $pdf->Cell(50, 10, $orderInfoRow['date_place'], 1, 1, 'C');
    }
    
    // Output the PDF
    $pdf->Output();
} else {
    // Handle the case where there are no order records
    echo "No order records found.";
}
?>
