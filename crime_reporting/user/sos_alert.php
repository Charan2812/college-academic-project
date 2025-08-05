<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include('../includes/header.php');
?>

<h2 class="text-center text-danger">Send Emergency SOS Alert</h2>

<form method="POST" class="w-75 mx-auto mt-4">
    <div class="mb-3">
        <label>Your Current Location</label>
        <input type="text" name="location" class="form-control" required placeholder="Example: Near ABC Road, Tirupati">
    </div>
    <button name="send" class="btn btn-danger w-100">🚨 Send SOS Alert</button>
</form>

<?php
if (isset($_POST['send'])) {
    include('../db/db.php');
    $user_id = $_SESSION['user_id'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("INSERT INTO sos_alerts (user_id, location) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $location);
    $stmt->execute();

    echo "<div class='alert alert-success text-center mt-3'>SOS Alert sent successfully!</div>";
}
include('../includes/footer.php'); ?>
