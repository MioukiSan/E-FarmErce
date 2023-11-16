<?php
require('../fpdf/FPDF.php');
require_once '../includes/db.php';

// Check if the form is submitted
if (isset($_POST['viewlog'])) {
    // Initialize PDF
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    // Set start and end dates
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];

    // Employee attendance query
    $attendanceSQL = "SELECT a.employee_id, a.date, a.attendance_status, e.fullname 
    FROM attendance a
    JOIN employee_management e ON e.employee_id = a.employee_id
    WHERE a.date BETWEEN '$start' AND '$end'";

    // Execute attendance query
    $attendanceResult = mysqli_query($conn, $attendanceSQL);

    // Check if there are attendance records
    if ($attendanceResult) {
        // Initialize PDF
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('Arial', 'B', 10);

        // Header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 1, 'E-FarmErce', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Ln(8);
        
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(0, 5, 'Sales Report', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, $start . ' - ' . $end, 0, 1, 'C');
        $pdf->Ln(5);

        // Table header
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(52, 162, 192);
        $pdf->Cell(50, 10, 'DATE', 1, 0, 'C', true);
        $pdf->Cell(80, 10, 'PRODUCT NAME', 1, 0, 'C', true);
        $pdf->Cell(80, 10, 'ORDER DETAILS', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'ATTENDANCE STATUS', 1, 1, 'C', true);

        $pdf->SetFillColor(52, 162, 192);
        $pdf->SetFont('Arial', '', 12);
        while ($row = mysqli_fetch_assoc($attendanceResult)) {
            $pdf->Cell(50, 10, $row['date'], 1, 0, 'C');
            $pdf->Cell(80, 10, $row['fullname'],  1, 0, 'C');
            $pdf->Cell(50, 10, $row['attendance_status'],  1, 1, 'C');
        }

        // Output the PDF
        $pdf->Output();
    } else {
        // Handle the case where there are no attendance records
        echo "No attendance records found.";
    }
} else {
    // Handle the case where the form is not submitted
    echo "Form not submitted.";
}
?>
