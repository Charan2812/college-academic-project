<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include('../includes/header.php');
?>

<h2 class="text-center">File FIR</h2>

<form action="" method="POST" class="w-75 mx-auto mt-3">
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label>Location</label>
        <input type="text" name="location" class="form-control" required>
    </div>
    <button name="submit" class="btn btn-danger">Submit FIR</button>
</form>

<?php
if (isset($_POST['submit'])) {
    include('../db/db.php');
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("INSERT INTO firs (user_id, title, description, location) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $desc, $location);
    $stmt->execute();

    echo "<div class='alert alert-success text-center mt-3'>FIR submitted successfully!</div>";
}
include('../includes/footer.php'); ?>
