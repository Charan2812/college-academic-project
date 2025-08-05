<?php include('includes/header.php'); ?>

<!-- Bootstrap Navbar -->
<nav class="navbar navbar-dark bg-dark d-md-none">
  <div class="container-fluid">
    <button class="btn btn-outline-light" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSidebar">
      ☰ Menu
    </button>
  </div>
</nav>

<div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 bg-dark text-white p-4 collapse d-md-block" id="mobileSidebar" style="min-height: 90vh;">
                <ul class="nav flex-column">
            <li class="nav-item mb-3">
                <a href="user/login.php" class="nav-link text-white bg-primary py-3 px-4 rounded fs-5 text-center">👤 User</a>
            </li>
            <li class="nav-item mb-3">
                <a href="police/login.php" class="nav-link text-white bg-success py-3 px-4 rounded fs-5 text-center">👮 Police</a>
            </li>
            <li class="nav-item mb-3">
                <a href="admin/login.php" class="nav-link text-white bg-danger py-3 px-4 rounded fs-5 text-center">🛠️ Admin</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 d-flex flex-column justify-content-center align-items-center text-center" style="min-height: 90vh;">
        <h2 class="text-primary mb-4 fw-bold">Welcome to <br> ONLINE CRIME REPORTING</h2>
        <img src="assets/images/banner.jpg" alt="Crime Reporting Banner" class="img-fluid rounded shadow mb-4" style="max-height: 400px;">
        <p class="text-muted fs-5">Your safety is our priority. Report any suspicious activity.<br>
        <strong class="text-danger">24/7 Help Service Available</strong></p>
    </div>
</div>
<script>
    const mainContent = document.getElementById('main-content');

    const params = new URLSearchParams(window.location.search);
    const loginStatus = params.get("login");

    if (loginStatus === "success") {
        window.location.href = "user/dashboard.php";
    } else if (loginStatus === "fail") {
        loadUserLogin("Invalid email or password.");
    }

    document.getElementById('linkUser').addEventListener('click', function(e) {
        e.preventDefault();
        history.pushState({}, '', '?login=show');
        loadUserLogin();
    });

    function loadUserLogin(errorMsg = "") {
        let errorHTML = errorMsg
            ? `<div class="alert alert-danger">${errorMsg}</div>`
            : "";

        mainContent.innerHTML = `
            ${errorHTML}
            <h3>User Login</h3>
            <form action="user/login.php" method="POST" class="mb-3" style="max-width: 400px;">
                <div class="mb-2">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <button class="btn btn-primary">Login</button>
                    <a href="user/register.php" class="btn btn-link">Register here</a>
                </div>
            </form>
        `;
    }
</script>

<?php include('includes/footer.php'); ?>
