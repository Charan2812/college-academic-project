<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('../includes/header.php');
include('../db/db.php');

// Handle assign form submission
$success = "";
if (isset($_POST['assign']) && isset($_POST['csr_id']) && isset($_POST['police_id'])) {
    $csr_id = $_POST['csr_id'];
    $police_id = $_POST['police_id'];

    $stmt = $conn->prepare("UPDATE csrs SET assigned_to = ?, status = 'Assigned' WHERE id = ?");
    $stmt->bind_param("ii", $police_id, $csr_id);
    if ($stmt->execute()) {
        $success = "✅ CSR ID $csr_id has been successfully assigned!";
    }
}

// Fetch all CSRs with user and assignment info
$result = $conn->query("
    SELECT c.*, u.name AS user_name, p.name AS officer_name
    FROM csrs c
    JOIN users u ON c.user_id = u.id
    LEFT JOIN police p ON c.assigned_to = p.id
    ORDER BY c.created_at DESC
");
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">All CSR Reports 📁</h2>
    <a href="export_csrs.php" class="btn btn-outline-primary mb-3">⬇️ Download CSR Report (.CSV)</a>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success text-center">
            <?= $success ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-warning">
            <tr>
                <th>CSR ID</th>
                <th>User Name</th>
                <th>Title</th>
                <th>Description</th>
                <th>Location</th>
                <th>Status</th>
                <th>Assigned Officer</th>
                <th>Filed On</th>
                <th>Assign Police</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['user_name'] ?></td>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['location'] ?></td>
                    <td><strong><?= $row['status'] ?></strong></td>
                    <td><?= $row['officer_name'] ?: 'Not Assigned' ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <form method="POST" class="d-flex">
                            <input type="hidden" name="csr_id" value="<?= $row['id'] ?>">
                            <select name="police_id" class="form-select me-2" required>
                                <option value="">Select</option>
                                <?php
                                $police = $conn->query("SELECT id, name FROM police");
                                while ($p = $police->fetch_assoc()):
                                ?>
                                    <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                                <?php endwhile; ?>
                            </select>
                            <button type="submit" name="assign" class="btn btn-sm btn-primary">Assign</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
