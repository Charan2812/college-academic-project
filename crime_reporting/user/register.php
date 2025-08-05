<?php include('../includes/header.php'); ?>
<h2 class="text-center"> 👤 User Registration</h2>

<form action="" method="POST" class="w-50 mx-auto">
  <div class="mb-3"><input type="text" name="name" placeholder="Full Name" class="form-control" required></div>
  <div class="mb-3"><input type="email" name="email" placeholder="Email" class="form-control" required></div>
  <div class="mb-3"><input type="text" name="mobile" placeholder="Mobile" class="form-control" required></div>
  <div class="mb-3"><input type="text" name="city" placeholder="City" class="form-control" required></div>
  <div class="mb-3"><input type="text" name="area" placeholder="Area" class="form-control" required></div>
  <div class="mb-3"><input type="password" name="password" placeholder="Password" class="form-control" required></div>
  <button class="btn btn-primary" name="register">Register</button>
</form>

<?php
if (isset($_POST['register'])) {
    include('../db/db.php');
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $city = $_POST['city'];
    $area = $_POST['area'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (name, email, mobile, city, area, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $mobile, $city, $area, $password);
    $stmt->execute();
    echo "<div class='alert alert-success text-center mt-3'>Registered successfully!</div>";
}
include('../includes/footer.php'); ?>
