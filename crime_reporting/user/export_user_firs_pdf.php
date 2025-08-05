<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require('../fpdf/fpdf.php');
include('../db/db.php');

$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT * FROM firs WHERE user_id = $user_id");

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->Cell(0, 10, 'My FIR Report', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Helvetica', '', 12);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(0, 10, "FIR ID: " . $row['id'], 0, 1);
    $pdf->MultiCell(0, 8, "Title: " . $row['title']);
    $pdf->MultiCell(0, 8, "Description: " . $row['description']);
    $pdf->Cell(0, 8, "Location: " . $row['location'], 0, 1);
    $pdf->Cell(0, 8, "Status: " . $row['status'], 0, 1);
    $pdf->Cell(0, 8, "Filed On: " . $row['created_at'], 0, 1);
    $pdf->Ln(5);
}

$pdf->Output('D', 'My_FIR_Report.pdf');
?>
