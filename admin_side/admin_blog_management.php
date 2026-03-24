<?php
session_start();
require_once '../backends/config.php';

$conn = get_db_connection();

/* LOGIN */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = true;

            header("Location: admin_blog_management.php");
            exit();
        }
    }

    die("Invalid credentials.");
}

/* UPLOAD */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_vlog'])) {

    $title = $_POST['title'];

    if (isset($_FILES['video']) && $_FILES['video']['error'] === 0) {

        $uploadDir = "../uploads/vlogs/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $videoName = time() . "_" . basename($_FILES["video"]["name"]);
        $targetFile = $uploadDir . $videoName;

        if (move_uploaded_file($_FILES["video"]["tmp_name"], $targetFile)) {

            $stmt = $conn->prepare("INSERT INTO vlogs (title, video_path, created_at) VALUES (?, ?, NOW())");
            $stmt->bind_param("ss", $title, $videoName);
            $stmt->execute();
            $stmt->close();

            header("Location: admin_blog_management.php");
            exit();
        }
    }
}

/* DELETE */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("DELETE FROM vlogs WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_blog_management.php");
    exit();
}

/* FETCH */
$result = $conn->query("SELECT id, title, video_path, created_at FROM vlogs ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vlog Management</title>

<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    /* ================================
   REAL ESTATE ADMIN DASHBOARD UI
   Dark Luxury Theme (ThreadVibe Style)
================================ */

@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --bg: #0f0f0f;
    --bg-2: #161616;
    --bg-3: #1e1e1e;
    --gold: #c9a84c;
    --gold-dim: rgba(201,168,76,0.15);
    --text: #f0ece3;
    --text-muted: #8a8278;
    --border: #2a2a2a;
    --radius: 8px;
}

/* ================= BODY ================= */
body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
}

/* ================= LAYOUT ================= */
.dashboard {
    display: flex;
}

/* ================= SIDEBAR ================= */
.sidebar {
    width: 250px;
    background: var(--bg-2);
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    border-right: 1px solid var(--border);
    transform: translateX(-100%);
    transition: 0.3s;
    z-index: 100;
}

.sidebar.open {
    transform: translateX(0);
}

.sidebar-brand {
    padding: 20px;
    border-bottom: 1px solid var(--border);
}

.brand-wordmark {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
}

.brand-wordmark span {
    color: var(--gold);
}

.brand-sub {
    font-size: 10px;
    color: var(--text-muted);
}

.sidebar-nav {
    padding: 10px 0;
}

.nav-item a {
    display: flex;
    gap: 10px;
    padding: 12px 20px;
    color: var(--text-muted);
    text-decoration: none;
}

.nav-item a:hover {
    background: var(--bg-3);
    color: var(--text);
}

/* ================= OVERLAY ================= */
.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
}

.sidebar-overlay.active {
    display: block;
}

/* ================= MAIN ================= */
.main-content {
    flex: 1;
    margin-left: 0;
    width: 100%;
}

/* ================= TOPBAR ================= */
.topbar {
    height: 60px;
    background: var(--bg-2);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    border-bottom: 1px solid var(--border);
}

.topbar-title {
    font-family: 'Playfair Display', serif;
}

.hamburger {
    background: none;
    border: 1px solid var(--border);
    padding: 6px;
    cursor: pointer;
}

.hamburger span {
    display: block;
    width: 18px;
    height: 2px;
    background: var(--text);
    margin: 3px 0;
}

.topbar-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.avatar {
    width: 32px;
    height: 32px;
    background: var(--gold-dim);
    color: var(--gold);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ================= CONTENT ================= */
.page-content {
    padding: 20px;
}

/* ================= HERO ================= */
.dash-hero {
    background: var(--bg-2);
    padding: 25px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    margin-bottom: 20px;
}

.dash-hero h2 {
    font-family: 'Playfair Display', serif;
}

/* ================= STATS ================= */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.stat-card {
    background: var(--bg-2);
    padding: 20px;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    position: relative;
}

.stat-label {
    font-size: 11px;
    color: var(--text-muted);
}

.stat-number {
    font-size: 28px;
    font-family: 'Playfair Display', serif;
}

.stat-icon {
    position: absolute;
    right: 15px;
    top: 15px;
    opacity: 0.3;
}

/* ================= CARD ================= */
.card {
    background: var(--bg-2);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    margin-bottom: 20px;
}

.card-header {
    padding: 15px;
    border-bottom: 1px solid var(--border);
}

.card-title {
    font-family: 'Playfair Display', serif;
}

.card-body {
    padding: 15px;
}

/* ================= TABLE ================= */
.table-responsive {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead th {
    text-align: left;
    padding: 10px;
    font-size: 11px;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
}

tbody td {
    padding: 12px;
    border-bottom: 1px solid var(--border);
}

tbody tr:hover {
    background: var(--bg-3);
}

/* ================= RESPONSIVE ================= */
@media (min-width: 1024px) {
    .sidebar {
        transform: translateX(0);
    }

    .main-content {
        margin-left: 250px;
    }

    .sidebar-overlay {
        display: none !important;
    }
}
/* FORM */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-size: 12px;
    color: #8a8278;
    margin-bottom: 5px;
}

.form-group input {
    width: 100%;
    padding: 10px;
    background: #1e1e1e;
    border: 1px solid #2a2a2a;
    color: #f0ece3;
    border-radius: 4px;
}

/* VIDEO */
video {
    border-radius: 6px;
    border: 1px solid #2a2a2a;
}

/* BUTTON */
.btn-primary {
    background: #c9a84c;
    color: #000;
    padding: 10px 15px;
    border: none;
    cursor: pointer;
}
</style>
</head>

<body>
<div class="dashboard">

<?php require_once '../backends/admin_sidebar.php'; ?>

<div class="main-content">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-left">
            <button class="hamburger" onclick="toggleSidebar()">
                <span></span><span></span><span></span>
            </button>
            <div class="topbar-title">Vlog Management</div>
        </div>

        <div class="topbar-right">
            <span class="topbar-user-name">
                <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?>
            </span>
            <div class="avatar">
                <?= strtoupper(substr($_SESSION['username'] ?? 'A',0,1)) ?>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="page-content">

        <!-- UPLOAD CARD -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Upload New Vlog</div>
            </div>

            <div class="card-body">

                <form method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>Vlog Title</label>
                        <input type="text" name="title" required>
                    </div>

                    <div class="form-group">
                        <label>Upload Video</label>
                        <input type="file" name="video" accept="video/*" required>
                    </div>

                    <button type="submit" name="upload_vlog" class="btn btn-primary">
                        <i class="fa fa-upload"></i> Upload
                    </button>

                </form>

            </div>
        </div>

        <!-- VLOG TABLE -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Uploaded Vlogs</div>
            </div>

            <div class="card-body">

                <?php if ($result->num_rows == 0): ?>
                    <div class="empty-state">
                        <span class="empty-icon"><i class="fa fa-video"></i></span>
                        <p>No vlogs uploaded.</p>
                    </div>
                <?php else: ?>

                <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Video</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>

                            <td><?= htmlspecialchars($row['title']) ?></td>

                            <td>
                                <video width="200" controls>
                                    <source src="../uploads/vlogs/<?= $row['video_path'] ?>" type="video/mp4">
                                </video>
                            </td>

                            <td><?= htmlspecialchars($row['created_at']) ?></td>

                            <td>
                                <a href="?delete=<?= $row['id'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Delete this vlog?')">
                                   <i class="fa fa-trash"></i>
                                </a>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
                </div>

                <?php endif; ?>

            </div>
        </div>

    </div>
</div>
</div>

<script src="../assets/js/sidebar.js"></script>

</body>
</html>