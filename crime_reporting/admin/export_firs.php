<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('../db/db.php');

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=fir_reports.csv");
header("Pragma: no-cache");
header("Expires: 0");

$output = fopen("php://output", "w");

// CSV Header
fputcsv($output, ['FIR ID', 'User ID', 'Title', 'Description', 'Location', 'Status', 'Filed On', 'Assigned To']);

$sql = "SELECT f.*, u.name AS user_name, p.name AS police_name
        FROM firs f 
        JOIN users u ON f.user_id = u.id 
        LEFT JOIN police p ON f.assigned_to = p.id 
        ORDER BY f.created_at DESC";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['id'],
        $row['user_id'],
        $row['title'],
        $row['description'],
        $row['location'],
        $row['status'],
        $row['created_at'],
        $row['police_name'] ?? 'Unassigned'
    ]);
}

fclose($output);
exit();
