<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include('../includes/header.php');
?>

<h2>Welcome, <?= $_SESSION['user_name']; ?> 👋</h2>
<p>Select an action:</p>

<!-- ✅ Download Buttons -->
<div class="mb-4">
      <a href="export_user_firs_pdf.php" class="btn btn-outline-primary mb-2">📄 Download My FIRs (PDF)</a>
<a href="export_user_csrs_pdf.php" class="btn btn-outline-success mb-2">📄 Download My CSRs (PDF)</a>

</div>

<!-- 🔗 Action Menu -->
<ul>
    <li><a href="create_fir.php">File FIR</a></li>
    <li><a href="create_csr.php">File CSR</a></li>
    <li><a href="view_status.php">View Complaint Status</a></li>
    <li><a href="sos_alert.php">Send SOS Alert</a></li>
    <li><a href="update_location.php">Update Location</a></li>
    <li><a href="logout.php" class="text-danger">Logout</a></li>
</ul>

<?php include('../includes/footer.php'); ?>
