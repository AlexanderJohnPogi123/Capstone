<?php
require_once '../backends/config.php'; 
$conn = get_db_connection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $firstname = sanitize_input($_POST['firstname']);
    $lastname  = sanitize_input($_POST['lastname']);
    $gmail     = sanitize_input($_POST['gmail']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {

        $username = $firstname . " " . $lastname;
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO admin_users (username, gmail, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $gmail, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Error: Email already exists or invalid input.');</script>";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
<div id="layoutAuthentication">
<div id="layoutAuthentication_content">
<main>
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-7">
<div class="card shadow-lg border-0 rounded-lg mt-5">

<div class="card-header">
    <h3 class="text-center font-weight-light my-4">Create Admin Account</h3>
</div>

<div class="card-body">

<form method="POST" action="">

<div class="row mb-3">
<div class="col-md-6">
<div class="form-floating mb-3 mb-md-0">
<input class="form-control" name="firstname" type="text" placeholder="First Name" required />
<label>First Name</label>
</div>
</div>

<div class="col-md-6">
<div class="form-floating">
<input class="form-control" name="lastname" type="text" placeholder="Last Name" required />
<label>Last Name</label>
</div>
</div>
</div>

<div class="form-floating mb-3">
<input class="form-control" name="gmail" type="email" placeholder="name@example.com" required />
<label>Email Address</label>
</div>

<div class="row mb-3">
<div class="col-md-6">
<div class="form-floating mb-3 mb-md-0">
<input class="form-control" name="password" type="password" placeholder="Password" required />
<label>Password</label>
</div>
</div>

<div class="col-md-6">
<div class="form-floating mb-3 mb-md-0">
<input class="form-control" name="confirm_password" type="password" placeholder="Confirm Password" required />
<label>Confirm Password</label>
</div>
</div>
</div>

<div class="mt-4 mb-0">
<div class="d-grid">
<button type="submit" class="btn btn-primary btn-block">
Create Account
</button>
</div>
</div>

</form>
</div>

<div class="card-footer text-center py-3">
<div class="small">
<a href="login.php">Have an account? Go to login</a>
</div>
</div>

</div>
</div>
</div>
</div>
</main>
</div>

<div id="layoutAuthentication_footer">
<footer class="py-4 bg-light mt-auto">
<div class="container-fluid px-4">
<div class="d-flex align-items-center justify-content-between small">
<div class="text-muted">Copyright &copy; Your Website 2026</div>
<div>
<a href="#">Privacy Policy</a>
&middot;
<a href="#">Terms &amp; Conditions</a>
</div>
</div>
</div>
</footer>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>