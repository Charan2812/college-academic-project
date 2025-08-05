<?php
session_start();
if (!isset($_SESSION['police_id'])) {
    header("Location: login.php");
    exit();
}

include('../includes/header.php');
include('../db/db.php');

$police_id = $_SESSION['police_id'];
$result = $conn->query("SELECT * FROM firs WHERE assigned_to = $police_id ORDER BY created_at DESC");
?>

<h2 class="text-center mb-4">Assigned FIR Complaints</h2>
<a href="export_firs_pdf.php" class="btn btn-outline-primary mb-3">📄 Download Assigned FIRs (PDF)</a>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Location</th>
            <th>Status</th>
            <th>Filed On</th>
            <th>Update</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['user_id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><?= $row['location'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="fir_id" value="<?= $row['id'] ?>">
                        <select name="new_status" class="form-select form-select-sm">
                            <option <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option <?= $row['status'] == 'In Process' ? 'selected' : '' ?>>In Process</option>
                            <option <?= $row['status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                        </select>
                        <button type="submit" name="update_fir" class="btn btn-sm btn-primary mt-1">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
if (isset($_POST['update_fir'])) {
    $fir_id = $_POST['fir_id'];
    $new_status = $_POST['new_status'];
    $stmt = $conn->prepare("UPDATE firs SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $fir_id);
    $stmt->execute();
    echo "<script>alert('Status updated successfully'); location.href='view_fir.php';</script>";
}
include('../includes/footer.php'); ?>
