<?php
session_start();
include('../includes/header.php'); 
require_once('../db/db.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM police WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result && $result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['police'] = $row['id']; 
        $_SESSION['police_name'] = $row['name']; // optional

        header("Location: dashboard.php"); 
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SOS Alerts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center text-danger">🚨 SOS Alerts from Users</h2>

        <table class="table table-bordered table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>User ID</th>
                    <th>Location</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM sos_alerts ORDER BY created_at DESC";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    $i = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$i}</td>
                            <td>{$row['user_id']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['created_at']}</td>
                        </tr>";
                        $i++;
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No SOS alerts found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include('../includes/footer.php');
 ?>