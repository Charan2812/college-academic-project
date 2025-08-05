<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('../includes/header.php');
include('../db/db.php');

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger text-center'>Invalid request.</div>";
    include('../includes/footer.php');
    exit();
}

$id = $_GET['id'];

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM released_criminals WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "<div class='alert alert-danger text-center'>Criminal record not found.</div>";
    include('../includes/footer.php');
    exit();
}

$row = $result->fetch_assoc();

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $criminal_id = $_POST['criminal_id'];
    $name = $_POST['name'];
    $type_of_release = $_POST['type_of_release'];
    $release_date = $_POST['release_date'];
    $remarks = $_POST['remarks'];

    $update = $conn->prepare("UPDATE released_criminals SET criminal_id = ?, name = ?, type_of_release = ?, release_date = ?, remarks = ? WHERE id = ?");
    $update->bind_param("sssssi", $criminal_id, $name, $type_of_release, $release_date, $remarks, $id);
    $update->execute();

    echo "<div class='alert alert-success text-center'>Criminal release record updated successfully!</div>";
    // Optionally redirect
    echo "<script>setTimeout(() => window.location='view_released_criminals.php', 2000);</script>";
}
?>

<div class="container mt-4">
    <h2 class="mb-4 text-center">✏️ Edit Released Criminal</h2>

    <form method="POST" class="w-50 mx-auto">
        <div class="mb-3">
            <label>Criminal ID</label>
            <input type="text" name="criminal_id" class="form-control" required value="<?= $row['criminal_id'] ?>">
        </div>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required value="<?= $row['name'] ?>">
        </div>
        <div class="mb-3">
            <label>Type of Release</label>
            <select name="type_of_release" class="form-select" required>
                <option value="Bail" <?= $row['type_of_release'] === 'Bail' ? 'selected' : '' ?>>Bail</option>
                <option value="Parole" <?= $row['type_of_release'] === 'Parole' ? 'selected' : '' ?>>Parole</option>
                <option value="Completed Sentence" <?= $row['type_of_release'] === 'Completed Sentence' ? 'selected' : '' ?>>Completed Sentence</option>
                <option value="Other" <?= $row['type_of_release'] === 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Release Date</label>
            <input type="date" name="release_date" class="form-control" required value="<?= $row['release_date'] ?>">
        </div>
        <div class="mb-3">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control" rows="3"><?= $row['remarks'] ?></textarea>
        </div>
        <button type="submit" class="btn btn-success w-100">Update</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>
