<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('../includes/header.php');
include('../db/db.php');
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Manage Users 👥</h2>

    <?php
    // Handle user deletion
    if (isset($_POST['delete_user'])) {
        $delete_id = $_POST['delete_id'];
        $conn->query("DELETE FROM users WHERE id = $delete_id");
        echo "<div class='alert alert-success text-center'>User deleted successfully!</div>";
    }

    // Fetch users
    $result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
    ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>City</th>
                <th>Area</th>
                <th>Registered</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['mobile'] ?></td>
                    <td><?= $row['city'] ?></td>
                    <td><?= $row['area'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete_user" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
