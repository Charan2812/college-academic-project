<?php
session_start();
include('../includes/header.php');
?>

<h2 class="text-center">👮Police Login</h2>

<form action="login.php" method="POST" class="w-50 mx-auto">
  <div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" required class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" required class="form-control">
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include('../db/db.php');

  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM police WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $police = $result->fetch_assoc();

  if ($police && password_verify($password, $police['password'])) {
    $_SESSION['police_id'] = $police['id'];
    $_SESSION['police_name'] = $police['name'];
    header("Location: dashboard.php");
  } else {
    echo "<div class='alert alert-danger text-center'>Invalid Credentials</div>";
  }
}
include('../includes/footer.php');
?>
