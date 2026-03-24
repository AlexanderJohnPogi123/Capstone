<?php
session_start();
require_once __DIR__ . '/../backends/config.php';

$conn = get_db_connection();

// Auth check
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Admin info
$stmt = $conn->prepare("SELECT username, gmail FROM admin_users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($username, $admin_email);

if ($stmt->fetch()) {
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $admin_email;
}
$stmt->close();

/* ================= COUNTS ================= */
$total_properties = $conn->query("SELECT COUNT(*) AS total FROM propertiies")->fetch_assoc()['total'] ?? 0;
$total_users = $conn->query("SELECT COUNT(*) AS total FROM userss")->fetch_assoc()['total'] ?? 0;
$total_reservations = $conn->query("SELECT COUNT(*) AS total FROM reservations")->fetch_assoc()['total'] ?? 0;
$total_blogs = $conn->query("SELECT COUNT(*) AS total FROM vlogs")->fetch_assoc()['total'] ?? 0;

/* ================= PIE DATA ================= */
$view_query = $conn->query("
    SELECT title, views
    FROM propertiies
    ORDER BY views DESC
    LIMIT 10
");

$pie_data = [];
while($row = $view_query->fetch_assoc()) {
    $pie_data[] = [decrypt_data($row['title']), (int)$row['views']];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://www.gstatic.com/charts/loader.js"></script>
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
.has-submenu .submenu {
    display: none;
    padding-left: 15px;
}

.has-submenu:hover .submenu {
    display: block;
}

.submenu a {
    display: block;
    padding: 8px 0;
    font-size: 14px;
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
            <div class="topbar-title">Dashboard</div>
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

        <!-- HERO -->
        <div class="dash-hero">
            <div class="dash-hero-eyebrow">Overview</div>
            <h2>Real Estate Admin Panel</h2>
            <p>Monitor your system performance and activity.</p>
        </div>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Properties</div>
                <div class="stat-number"><?= $total_properties ?></div>
                <div class="stat-icon"><i class="fa fa-home"></i></div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Users</div>
                <div class="stat-number"><?= $total_users ?></div>
                <div class="stat-icon"><i class="fa fa-users"></i></div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Reservations</div>
                <div class="stat-number"><?= $total_reservations ?></div>
                <div class="stat-icon"><i class="fa fa-calendar-check"></i></div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Blogs</div>
                <div class="stat-number"><?= $total_blogs ?></div>
                <div class="stat-icon"><i class="fa fa-blog"></i></div>
            </div>
        </div>

        <!-- PIE CHART -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Most Viewed Properties</div>
            </div>
            <div class="card-body">
                <div id="piechart" style="height:400px;"></div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Recent Reservations</div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Property</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $conn = get_db_connection();
                    $result = $conn->query("SELECT * FROM reservations ORDER BY id DESC LIMIT 5");

                    while($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($row['fullname']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td><?= htmlspecialchars($row['property']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                        </tr>
                    <?php endwhile; $conn->close(); ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
</div>

<!-- CHART -->
<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Property', 'Views'],
        <?php
        foreach ($pie_data as $pd) {
            echo "['".$pd[0]."', ".$pd[1]."],";
        }
        ?>
    ]);

    var options = {
        backgroundColor: 'transparent',
        legendTextStyle: { color: '#f0ece3' },
        titleTextStyle: { color: '#f0ece3' },
        pieHole: 0.4
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
}
</script>

<script src="../assets/js/sidebar.js"></script>

</body>
</html>