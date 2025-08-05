<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include('../includes/header.php');
include('../db/db.php');

$user_id = $_SESSION['user_id'];
?>

<h2 class="text-center">Your Complaint Status</h2>

<!-- FIRs -->
<h4 class="mt-4">FIR Reports</h4>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr><th>ID</th><th>Title</th><th>Description</th><th>Status</th><th>Filed On</th></tr>
    </thead>
    <tbody>
        <?php
        $firs = $conn->query("SELECT * FROM firs WHERE user_id = $user_id");
        while ($row = $firs->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['created_at']}</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

<!-- CSRs -->
<h4 class="mt-4">CSR Reports</h4>
<table class="table table-bordered">
    <thead class="table-warning">
        <tr><th>ID</th><th>Title</th><th>Description</th><th>Status</th><th>Filed On</th></tr>
    </thead>
    <tbody>
        <?php
        $csrs = $conn->query("SELECT * FROM csrs WHERE user_id = $user_id");
        while ($row = $csrs->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['created_at']}</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

<?php include('../includes/footer.php'); ?>
