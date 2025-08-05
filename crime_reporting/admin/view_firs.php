<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('../includes/header.php');
include('../db/db.php');

// Assign FIR to police
if (isset($_POST['assign'])) {
    $fir_id = $_POST['fir_id'];
    $police_id = $_POST['police_id'];
    $conn->query("UPDATE firs SET assigned_to = $police_id WHERE id = $fir_id");
    echo "<div class='alert alert-success text-center'>FIR #$fir_id assigned to police officer ID: $police_id</div>";
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Assign FIR Reports to Police 👮</h2>
  <div class="text-end mb-3">
        <a href="export_firs.php" class="btn btn-outline-primary">
            ⬇️ Download FIR Report (.CSV)
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>User</th>
                <th>Description</th>
                <th>Status</th>
                <th>Location</th>
                <th>Filed On</th>
                <th>Assigned To</th>
                <th>Assign</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $firs = $conn->query("SELECT f.*, u.name AS user_name, p.name AS police_name FROM firs f 
                                  JOIN users u ON f.user_id = u.id 
                                  LEFT JOIN police p ON f.assigned_to = p.id 
                                  ORDER BY f.created_at DESC");

            $policeList = $conn->query("SELECT id, name FROM police");
            $policeOptions = "";
            while ($p = $policeList->fetch_assoc()) {
                $policeOptions .= "<option value='{$p['id']}'>{$p['name']} (ID: {$p['id']})</option>";
            }

            while ($row = $firs->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['user_name']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['location']}</td>
                        <td>{$row['created_at']}</td>
                        <td>" . ($row['police_name'] ?? "<span class='text-muted'>Unassigned</span>") . "</td>
                        <td>
                            <form method='POST'>
                                <input type='hidden' name='fir_id' value='{$row['id']}'>
                                <select name='police_id' class='form-select form-select-sm mb-1' required>
                                    <option value=''>Assign to...</option>
                                    $policeOptions
                                </select>
                                <button name='assign' class='btn btn-sm btn-primary w-100'>Assign</button>
                            </form>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
