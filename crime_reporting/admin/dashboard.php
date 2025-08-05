<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('../includes/header.php');
include('../db/db.php');

// Fetch counts
$firs     = $conn->query("SELECT COUNT(*) AS total FROM firs")->fetch_assoc()['total'];
$csrs     = $conn->query("SELECT COUNT(*) AS total FROM csrs")->fetch_assoc()['total'];
$sos      = $conn->query("SELECT COUNT(*) AS total FROM sos_alerts")->fetch_assoc()['total'];
$police   = $conn->query("SELECT COUNT(*) AS total FROM police")->fetch_assoc()['total'];
$users    = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$released = $conn->query("SELECT COUNT(*) AS total FROM released_criminals")->fetch_assoc()['total'];
?>

<div class="container mt-4">
    <h2 class="text-center">Welcome, Admin <?= $_SESSION['admin']; ?> 🎓</h2>
    <p class="text-center">Here is the overall system summary:</p>

    <div class="row text-center mt-5">
        <div class="col-md-4 mb-3">
            <div class="card border-left-danger shadow p-3">
                <h5>Total FIRs</h5>
                <p class="fs-3 text-danger"><?= $firs ?></p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-left-warning shadow p-3">
                <h5>Total CSRs</h5>
                <p class="fs-3 text-warning"><?= $csrs ?></p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-left-primary shadow p-3">
                <h5>SOS Alerts</h5>
                <p class="fs-3 text-primary"><?= $sos ?></p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-left-success shadow p-3">
                <h5>Registered Users</h5>
                <p class="fs-3 text-success"><?= $users ?></p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-left-info shadow p-3">
                <h5>Police Accounts</h5>
                <p class="fs-3 text-info"><?= $police ?></p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-left-dark shadow p-3">
                <h5>Released Criminals</h5>
                <p class="fs-3 text-dark"><?= $released ?></p>
                <a href="view_released_criminals.php" class="btn btn-outline-dark btn-sm">View</a>
            </div>
        </div>
    </div>

    <div class="text-center mb-4">
        <a href="add_criminal_release.php" class="btn btn-primary mt-2">➕ Add Released Criminal</a>
    </div>

    <hr class="my-4">

    <h4>Manage Sections</h4>
    <ul>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_police.php">Manage Police</a></li>
        <li><a href="view_firs.php">View FIR Reports</a></li>
        <li><a href="view_csrs.php">View CSR Reports</a></li>
        <li><a href="sos_alerts.php">View SOS Alerts</a></li>
        <li><a href="view_released_criminals.php">View Released Criminals</a></li>
        <li><a href="manage_master.php">Master Data</a></li>
        <li><a href="logout.php" class="text-danger">Logout</a></li>
    </ul>
</div>

<?php include('../includes/footer.php'); ?>
