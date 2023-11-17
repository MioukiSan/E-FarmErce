<?php
require('../fpdf/FPDF.php');
require_once '../includes/db.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['view'])) {
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $queryO = "SELECT * FROM orders WHERE DATE(date_place) BETWEEN '$start' AND '$end' AND seller_id = '$user_id' AND order_status != 'Cancelled'";
    $queryR = mysqli_query($conn, $queryO);
    $totalSales = 0;
} else {
    $this_date = $_POST['this_date'];
    $queryO = "SELECT * FROM orders WHERE DATE(date_place) = '$this_date' AND seller_id = '$user_id' AND order_status != 'Cancelled'";
    $queryR = mysqli_query($conn, $queryO);
    $totalSales = 0;
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
    $pdf->Cell(0, 5, 'DATE: ' . $start . ' - ' . $end, 0, 1, 'C');
    } else {
        $pdf->Cell(0, 5, 'DATE: ' . $this_date, 0, 1, 'C');
    }
    $pdf->Ln(5);

    // Table header
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetFillColor(52, 162, 192);
    $pdf->Cell(32, 10, 'BUYER', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'DATE ORDERED', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'PRODUCT', 1, 0, 'C', true);
    $pdf->Cell(16, 10, 'QTY', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'TRANSACT MODE', 1, 0, 'C', true);
    $pdf->Cell(25, 10, 'STATUS', 1, 0, 'C', true);
    $pdf->Cell(27, 10, 'TOTAL', 1, 1, 'C', true);

    $pdf->SetFillColor(52, 162, 192);
    $pdf->SetFont('Arial', '', 9);

    while ($orderInfoRow = mysqli_fetch_assoc($queryR)) {
        $product_id = $orderInfoRow['product_id'];
        $datePlace = $orderInfoRow['date_place'];
        $onlyDate = date('Y-m-d', strtotime($datePlace));
        $buyer_id = $orderInfoRow['user_id'];
        $totalSales += $orderInfoRow['order_total'];

        $fetchfullName = "SELECT fullname FROM users WHERE user_id = $buyer_id";
        $fetchRes = mysqli_query($conn, $fetchfullName);
        $rrow = mysqli_fetch_assoc($fetchRes);
        $buyerName = $rrow['fullname'];

        $queryInfoProd = "SELECT * FROM products WHERE product_id = ?";
        $stmt = mysqli_prepare($conn, $queryInfoProd);
        mysqli_stmt_bind_param($stmt, 's', $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
    
        $pdf->Cell(32, 10, $buyerName, 1, 0, 'C');
        $pdf->Cell(30, 10, $onlyDate, 1, 0, 'C');
        $pdf->Cell(30, 10, $row['product_name'], 1, 0, 'C');
        $pdf->Cell(16, 10, $orderInfoRow['order_qty'] . ' kg', 1, 0, 'C');
        $pdf->Cell(30, 10, $orderInfoRow['transact_mode'], 1, 0, 'C');
        $pdf->Cell(25, 10, $orderInfoRow['order_status'], 1, 0, 'C');
        $pdf->Cell(27, 10, CURRENCY . number_format($orderInfoRow['order_total'], 2), 1, 1, 'R');

    }
    $pdf->SetFillColor(192, 192, 192);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(163, 8, 'Total Sales', 1, 0, 'C', true);
    $pdf->Cell(27, 8, CURRENCY . number_format($totalSales, 2), 1, 1, 'R', true);
    // Output the PDF
    $pdf->Output();
} else {
    // Handle the case where there are no order records
    echo "No order records found.";
}
?>
