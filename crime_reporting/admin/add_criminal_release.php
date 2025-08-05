<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('../includes/header.php');
include('../db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $criminal_id = $_POST['criminal_id'];
    $name = $_POST['name'];
    $type_of_release = $_POST['type_of_release'];
    $release_date = $_POST['release_date'];
    $remarks = $_POST['remarks'];

    $stmt = $conn->prepare("INSERT INTO released_criminals (criminal_id, name, type_of_release, release_date, remarks) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $criminal_id, $name, $type_of_release, $release_date, $remarks);
    $stmt->execute();

    echo "<div class='alert alert-success text-center'>Criminal release info added successfully!</div>";
}
?>

<div class="container mt-4">
    <h2 class="mb-4 text-center">➕ Add Released Criminal Details</h2>
    <form method="POST" class="w-50 mx-auto">
        <div class="mb-3">
            <label>Criminal ID</label>
            <input type="text" name="criminal_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Criminal Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Type of Release</label>
            <select name="type_of_release" class="form-select" required>
                <option value="Bail">Bail</option>
                <option value="Parole">Parole</option>
                <option value="Completed Sentence">Completed Sentence</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Date of Release</label>
            <input type="date" name="release_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control" rows="3"></textarea>
        </div>
        <button class="btn btn-primary w-100">Submit</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
