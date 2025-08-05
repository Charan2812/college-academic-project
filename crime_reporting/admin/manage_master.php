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
    <h2 class="text-center mb-4">Master Data Management 📋</h2>

    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#city">Cities</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#area">Areas</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#dept">Departments</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#cat">Categories</a></li>
    </ul>

    <div class="tab-content">
        <!-- CITIES -->
        <div class="tab-pane fade show active" id="city">
            <form method="POST" class="input-group w-50 mb-3">
                <input type="text" name="city" class="form-control" placeholder="Enter City" required>
                <button name="add_city" class="btn btn-primary">Add</button>
            </form>
            <?php
            if (isset($_POST['add_city'])) {
                $city = $_POST['city'];
                $conn->query("INSERT INTO cities (name) VALUES ('$city')");
            }
            $cities = $conn->query("SELECT * FROM cities");
            echo "<ul class='list-group w-50'>";
            while ($row = $cities->fetch_assoc()) {
                echo "<li class='list-group-item'>{$row['name']}</li>";
            }
            echo "</ul>";
            ?>
        </div>

        <!-- AREAS -->
        <div class="tab-pane fade" id="area">
            <form method="POST" class="row g-2 align-items-center mb-3 w-75">
                <div class="col-md-5">
                    <select name="city_id" class="form-select" required>
                        <option value="">-- Select City --</option>
                        <?php
                        $res = $conn->query("SELECT * FROM cities");
                        while ($c = $res->fetch_assoc()) {
                            echo "<option value='{$c['id']}'>{$c['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" name="area" class="form-control" placeholder="Enter Area" required>
                </div>
                <div class="col-md-2">
                    <button name="add_area" class="btn btn-success w-100">Add</button>
                </div>
            </form>
            <?php
            if (isset($_POST['add_area'])) {
                $city_id = $_POST['city_id'];
                $area = $_POST['area'];
                $conn->query("INSERT INTO areas (name, city_id) VALUES ('$area', $city_id)");
            }
            $areas = $conn->query("SELECT a.name AS area, c.name AS city FROM areas a JOIN cities c ON a.city_id = c.id");
            echo "<ul class='list-group w-75'>";
            while ($row = $areas->fetch_assoc()) {
                echo "<li class='list-group-item'>{$row['city']} → {$row['area']}</li>";
            }
            echo "</ul>";
            ?>
        </div>

        <!-- DEPARTMENTS -->
        <div class="tab-pane fade" id="dept">
            <form method="POST" class="input-group w-50 mb-3">
                <input type="text" name="department" class="form-control" placeholder="Enter Department" required>
                <button name="add_dept" class="btn btn-warning">Add</button>
            </form>
            <?php
            if (isset($_POST['add_dept'])) {
                $dept = $_POST['department'];
                $conn->query("INSERT INTO departments (name) VALUES ('$dept')");
            }
            $depts = $conn->query("SELECT * FROM departments");
            echo "<ul class='list-group w-50'>";
            while ($row = $depts->fetch_assoc()) {
                echo "<li class='list-group-item'>{$row['name']}</li>";
            }
            echo "</ul>";
            ?>
        </div>

        <!-- CATEGORIES -->
        <div class="tab-pane fade" id="cat">
            <form method="POST" class="input-group w-50 mb-3">
                <input type="text" name="category" class="form-control" placeholder="Enter Category" required>
                <button name="add_cat" class="btn btn-info">Add</button>
            </form>
            <?php
            if (isset($_POST['add_cat'])) {
                $cat = $_POST['category'];
                $conn->query("INSERT INTO categories (name) VALUES ('$cat')");
            }
            $cats = $conn->query("SELECT * FROM categories");
            echo "<ul class='list-group w-50'>";
            while ($row = $cats->fetch_assoc()) {
                echo "<li class='list-group-item'>{$row['name']}</li>";
            }
            echo "</ul>";
            ?>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
