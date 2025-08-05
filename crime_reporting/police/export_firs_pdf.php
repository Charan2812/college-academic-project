<?php
session_start();
if (!isset($_SESSION['police_id'])) {
    header("Location: login.php");
    exit();
}

require('../fpdf/fpdf.php');
require('../db/db.php');

$police_id = $_SESSION['police_id'];
$result = $conn->query("SELECT * FROM firs WHERE assigned_to = $police_id ORDER BY created_at DESC");

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Assigned FIR Reports', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 10, 'ID', 1);
$pdf->Cell(30, 10, 'User ID', 1);
$pdf->Cell(40, 10, 'Title', 1);
$pdf->Cell(35, 10, 'Location', 1);
$pdf->Cell(30, 10, 'Status', 1);
$pdf->Cell(40, 10, 'Filed On', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 11);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(15, 10, $row['id'], 1);
    $pdf->Cell(30, 10, $row['user_id'], 1);
    $pdf->Cell(40, 10, substr($row['title'], 0, 20), 1);
    $pdf->Cell(35, 10, substr($row['location'], 0, 20), 1);
    $pdf->Cell(30, 10, $row['status'], 1);
    $pdf->Cell(40, 10, date('d-m-Y', strtotime($row['created_at'])), 1);
    $pdf->Ln();
}

$pdf->Output('D', 'Assigned_FIR_Reports.pdf');
?>
