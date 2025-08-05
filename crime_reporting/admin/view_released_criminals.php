<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('../includes/header.php');
include('../db/db.php');

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM released_criminals WHERE id = $id");
    echo "<div class='alert alert-success text-center'>Record deleted successfully.</div>";
}

$result = $conn->query("SELECT * FROM released_criminals ORDER BY release_date DESC");
?>

<div class="container mt-4">
    <h2 class="mb-4 text-center">📂 Released Criminals</h2>

    <a href="add_criminal_release.php" class="btn btn-primary mb-3">➕ Add New Release</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Criminal ID</th>
                <th>Name</th>
                <th>Type of Release</th>
                <th>Release Date</th>
                <th>Remarks</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
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
                        <td>
                            <a href='edit_criminal_release.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='view_released_criminals.php?delete={$row['id']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>
                        </td>
                    </tr>";
                    $i++;
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No released criminal records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
