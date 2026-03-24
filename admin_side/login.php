<?php
session_start();
require_once __DIR__ . '/../backends/config.php';

$conn = get_db_connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, username, password FROM admin_users WHERE gmail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($admin_id, $username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['id'] = $admin_id;
            $_SESSION['username'] = $username;
            $_SESSION['gmail'] = $email;

            header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Admin not found.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Login</title>

<link href="assets/styles.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<div class="auth-wrapper">

    <!-- LEFT SIDE -->
    <div class="auth-visual">
        <div class="auth-visual-text">
            <div class="auth-visual-logo">Real<span>Estate</span></div>
            <div class="auth-visual-tagline">Admin Panel</div>
            <div class="auth-visual-quote">
                Manage your system with elegance and control.
            </div>
        </div>

        <div class="auth-decorlines">
            <span style="--i:1"></span>
            <span style="--i:2"></span>
            <span style="--i:3"></span>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="auth-form-side">

        <div class="auth-card">

            <div class="auth-card-header">
                <h2>Admin Login</h2>
                <p>Enter your credentials</p>
            </div>

            <?php if (!empty($error)) : ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group password-wrapper">
                    <label>Password</label>
                    <input type="password" name="password" id="password" required>

                    <button type="button" class="pw-toggle" onclick="togglePassword()">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    Login
                </button>

            </form>

        </div>

    </div>

</div>

<script>
function togglePassword() {
    const pw = document.getElementById('password');
    pw.type = pw.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>