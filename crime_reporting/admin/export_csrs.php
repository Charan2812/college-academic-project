<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require_once('../db/db.php');

// Set headers to force download as CSV
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=csr_reports.csv");
header("Pragma: no-cache");
header("Expires: 0");

// Open output stream
$output = fopen("php://output", "w");

// Add CSV column headers
fputcsv($output, ['CSR ID', 'User ID', 'User Name', 'Title', 'Description', 'Location', 'Status', 'Filed On']);

// Fetch data from CSRs
$query = "
    SELECT c.*, u.name AS user_name 
    FROM csrs c 
    JOIN users u ON c.user_id = u.id 
    ORDER BY c.created_at DESC
";

$result = $conn->query($query);

// Write each row to CSV
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['id'],
            $row['user_id'],
            $row['user_name'],
            $row['title'],
            $row['description'],
            $row['location'],
            $row['status'],
            $row['created_at']
        ]);
    }
} else {
    fputcsv($output, ['No data found']);
}

fclose($output);
exit();
?>
