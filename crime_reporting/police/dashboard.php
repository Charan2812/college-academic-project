<?php
session_start();
if (!isset($_SESSION['police_id'])) {
    header("Location: login.php");
    exit();
}
include('../includes/header.php');
include('../db/db.php');

// ✅ New Release Alert Check
$release_alert = '';
$latest_release = $conn->query("SELECT * FROM released_criminals WHERE created_at >= NOW() - INTERVAL 1 DAY ORDER BY created_at DESC LIMIT 1");
if ($latest_release && $latest_release->num_rows > 0) {
    $row = $latest_release->fetch_assoc();
    $release_alert = "New Criminal Released: <strong>{$row['name']}</strong> ({$row['type_of_release']}) on {$row['release_date']}.";
}
?>

<h2 class="text-center mb-4">Welcome, Officer <?= $_SESSION['police_name']; ?></h2>

<?php if ($release_alert): ?>
    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
        🚨 <?= $release_alert ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row text-center">
    <?php
    $fir_count = $conn->query("SELECT COUNT(*) as total FROM firs")->fetch_assoc()['total'];
    $csr_count = $conn->query("SELECT COUNT(*) as total FROM csrs")->fetch_assoc()['total'];
    $sos_count = $conn->query("SELECT COUNT(*) as total FROM sos_alerts")->fetch_assoc()['total'];
    ?>

    <div class="col-md-4 mb-3">
        <div class="card shadow border-left-danger">
            <div class="card-body">
                <h4>Total FIRs</h4>
                <p class="fs-3 text-danger"><?= $fir_count ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow border-left-warning">
            <div class="card-body">
                <h4>Total CSRs</h4>
                <p class="fs-3 text-warning"><?= $csr_count ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow border-left-primary">
            <div class="card-body">
                <h4>SOS Alerts</h4>
                <p class="fs-3 text-primary"><?= $sos_count ?></p>
            </div>
        </div>
    </div>
</div>

<hr>
<ul>
    <li><a href="view_fir.php">View FIRs</a></li>
    <li><a href="view_csr.php">View CSRs</a></li>
    <li><a href="sos_alerts.php">SOS Alerts</a></li>
    <li><a href="logout.php" class="text-danger">Logout</a></li>
</ul>

<hr class="my-4">
<h4 class="text-danger">🚨 Recently Released Criminals</h4>

<table class="table table-bordered table-striped mt-3">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Criminal ID</th>
            <th>Name</th>
            <th>Type of Release</th>
            <th>Release Date</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM released_criminals ORDER BY release_date DESC LIMIT 5";
        $result = $conn->query($query);
        $i = 1;
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$i}</td>
                    <td>{$row['criminal_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['type_of_release']}</td>
                    <td>{$row['release_date']}</td>
                    <td>{$row['remarks']}</td>
                </tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>No released criminal records found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include('../includes/footer.php'); ?>
