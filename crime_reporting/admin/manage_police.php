<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include('../includes/header.php');
include('../db/db.php');

// Handle add police
if (isset($_POST['add_police'])) {
    $name       = $_POST['name'];
    $username   = $_POST['username'];
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $mobile     = $_POST['mobile'];
    $department = $_POST['department'];
    $city       = $_POST['city'];
    $area       = $_POST['area'];

    $stmt = $conn->prepare("INSERT INTO police (name, username, password, mobile, department, city, area) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $username, $password, $mobile, $department, $city, $area);
    $stmt->execute();
    echo "<div class='alert alert-success text-center'>Police officer added successfully!</div>";
}

// Handle delete police
if (isset($_POST['delete_police'])) {
    $delete_id = $_POST['delete_id'];
    $conn->query("DELETE FROM police WHERE id = $delete_id");
    echo "<div class='alert alert-danger text-center'>Police officer deleted.</div>";
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Manage Police Officers 👮</h2>

    <!-- Add Police Form -->
    <form method="POST" class="border p-4 mb-4 bg-light rounded">
        <h5>Add New Police</h5>
        <div class="row">
            <div class="col-md-4 mb-2">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-md-4 mb-2">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="col-md-4 mb-2">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="col-md-4 mb-2">
                <input type="text" name="mobile" class="form-control" placeholder="Mobile" required>
            </div>
            <div class="col-md-4 mb-2">
                <input type="text" name="department" class="form-control" placeholder="Department" required>
            </div>
            <div class="col-md-4 mb-2">
                <input type="text" name="city" class="form-control" placeholder="City" required>
            </div>
            <div class="col-md-4 mb-2">
                <input type="text" name="area" class="form-control" placeholder="Area" required>
            </div>
        </div>
        <button type="submit" name="add_police" class="btn btn-primary mt-2">Add Police</button>
    </form>

    <!-- Police List Table -->
    <?php
    $result = $conn->query("SELECT * FROM police ORDER BY id DESC");
    ?>
    <h5 class="mb-3">Police List</h5>
    <table class="table table-bordered table-striped">
        <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Mobile</th>
                <th>Department</th>
                <th>City</th>
                <th>Area</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['mobile'] ?></td>
                    <td><?= $row['department'] ?></td>
                    <td><?= $row['city'] ?></td>
                    <td><?= $row['area'] ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Delete this police officer?');">
                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete_police" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php'); ?>
