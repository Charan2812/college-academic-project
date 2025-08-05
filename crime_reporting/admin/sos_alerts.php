<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('../includes/header.php');
include('../db/db.php');

$result = $conn->query("SELECT s.*, u.name AS user_name FROM sos_alerts s JOIN users u ON s.user_id = u.id ORDER BY s.created_at DESC");
?>

<div class="container mt-4">
    <h2 class="text-center mb-4 text-danger">SOS Alerts 🚨</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-danger">
            <tr>
                <th>Alert ID</th>
                <th>User Name</th>
                <th>Location</th>
                <th>Alert Time</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['user_name'] ?></td>
                    <td><?= $row['location'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
