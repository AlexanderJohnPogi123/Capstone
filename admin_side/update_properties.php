<?php
session_start();
require_once __DIR__ . '/../backends/config.php';

$conn = get_db_connection();

// Auth check
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

/* ================= UPDATE ================= */
if (isset($_POST['update_property'])) {

    $id = intval($_POST['id']);
    $price = floatval($_POST['price']);

    if (!empty($_FILES['image']['tmp_name'])) {

        $imageName = basename($_FILES['image']['name']);
        $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if(!in_array($ext,$allowed)){
            die("Invalid file type.");
        }

        $targetDir = __DIR__ . '/../photo/uploads/';
        $targetFile = $targetDir . $imageName;

        if(!move_uploaded_file($_FILES['image']['tmp_name'],$targetFile)){
            die("Upload failed.");
        }

        $encryptedImage = encrypt_data($imageName);

        $stmt = $conn->prepare("UPDATE propertiies SET price=?, image=? WHERE id=?");
        $stmt->bind_param("dsi",$price,$encryptedImage,$id);

    } else {

        $stmt = $conn->prepare("UPDATE propertiies SET price=? WHERE id=?");
        $stmt->bind_param("di",$price,$id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: update_properties.php?updated=1");
    exit;
}

/* ================= DELETE ================= */
if (isset($_POST['delete_property'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM propertiies WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();

    header("Location: update_properties.php");
    exit;
}

/* ================= FETCH ================= */
$properties_result = $conn->query("SELECT * FROM propertiies ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Properties</title>

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
            <div class="topbar-title">Update Properties</div>
        </div>

        <div class="topbar-right">
            <span class="topbar-user-name">
                <?= htmlspecialchars($_SESSION['username']) ?>
            </span>
            <div class="avatar">
                <?= strtoupper(substr($_SESSION['username'],0,1)) ?>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="page-content">

        <?php if(isset($_GET['updated'])): ?>
            <div class="alert alert-success">Property updated successfully</div>
        <?php endif; ?>

        <!-- CARD -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">All Properties</div>
            </div>

            <div class="card-body">

                <?php if ($properties_result->num_rows == 0): ?>
                    <div class="empty-state">
                        <span class="empty-icon"><i class="fa fa-home"></i></span>
                        <p>No properties found.</p>
                    </div>
                <?php else: ?>

                <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Location</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php while ($row = $properties_result->fetch_assoc()): ?>
                        <tr>
                        <form method="POST" enctype="multipart/form-data">

                            <td>
                                <?= $row['id'] ?>
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            </td>

                            <td>
                                <input type="text"
                                    value="<?= htmlspecialchars(decrypt_data($row['title'])) ?>"
                                    readonly>
                            </td>

                            <td>
                                <input type="number" step="0.01" name="price"
                                    value="<?= $row['price'] ?>" required>
                            </td>

                            <td>
                                <input type="text"
                                    value="<?= htmlspecialchars(decrypt_data($row['location'])) ?>"
                                    readonly>
                            </td>

                            <td>
                                <input type="file" name="image">
                            </td>

                            <td>
                                <button type="submit" name="update_property" class="btn btn-success btn-sm">
                                    <i class="fa fa-edit"></i> Update
                                </button>

                                <button type="submit" name="delete_property" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this property?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>

                        </form>
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