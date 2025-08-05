<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include('../includes/header.php');
?>

<h2 class="text-center">Update Your Current Location</h2>

<form method="POST" class="w-75 mx-auto mt-4">
    <div class="mb-3">
        <label>New Location</label>
        <input type="text" name="location" class="form-control" required placeholder="New Area / Street Name">
    </div>
    <button name="update" class="btn btn-success">Update Location</button>
</form>

<?php
if (isset($_POST['update'])) {
    include('../db/db.php');
    $user_id = $_SESSION['user_id'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("UPDATE users SET area = ? WHERE id = ?");
    $stmt->bind_param("si", $location, $user_id);
    $stmt->execute();

    echo "<div class='alert alert-success text-center mt-3'>Location updated!</div>";
}
include('../includes/footer.php'); ?>
