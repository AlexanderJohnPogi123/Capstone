<?php
session_start();
require_once __DIR__ . '/../backends/config.php';   

$conn = get_db_connection();

// Check if admin is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Fetch admin info
$stmt = $conn->prepare("SELECT username, gmail FROM admin_users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($username, $admin_email);

if ($stmt->fetch()) {
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $admin_email;
}
$stmt->close();

/* ===============================
   DASHBOARD COUNTS
================================*/

// Total Properties
$result = $conn->query("SELECT COUNT(*) AS total FROM propertiies");
$total_properties = $result->fetch_assoc()['total'] ?? 0;

// Total Users
$result = $conn->query("SELECT COUNT(*) AS total FROM userss");
$total_users = $result->fetch_assoc()['total'] ?? 0;

// Total Reservations
$result = $conn->query("SELECT COUNT(*) AS total FROM reservations");
$total_reservations = $result->fetch_assoc()['total'] ?? 0;

// Total Blogs
$result = $conn->query("SELECT COUNT(*) AS total FROM vlogs");
$total_blogs = $result->fetch_assoc()['total'] ?? 0;

/* ===============================
   MOST VIEWED PROPERTIES DATA
================================*/
$view_query = $conn->query("
    SELECT title, location, views
    FROM propertiies
    ORDER BY view_count DESC
    LIMIT 10
");

$most_viewed = [];
while($row = $view_query->fetch_assoc()) {
    $most_viewed[] = $row;
}

// Prepare data for pie chart
$pie_data = [];
foreach($most_viewed as $prop) {
    $pie_data[] = [decrypt_data($prop['title']), (int)$prop['views']];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<title>Dashboard - Real Estate Admin</title>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
<link href="css/styles.css" rel="stylesheet" />
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body class="sb-nav-fixed">

<!-- NAVBAR -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.php">Real Estate Admin</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-user fa-fw"></i>
                <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>

<div id="layoutSidenav">
    <!-- SIDEBAR -->
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <!-- Properties -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProperties">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Properties
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseProperties" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="../backends/add-property.php">Upload</a>
                            <a class="nav-link" href="update_properties.php">Update</a>
                        </nav>
                    </div>
                    <!-- Blog -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBlog">
                        <div class="sb-nav-link-icon"><i class="fas fa-blog"></i></div>
                        Blog
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseBlog" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="admin_blog_management.php">Manage Blogs</a>
                        </nav>
                    </div>
                   
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
            </div>
        </nav>
    </div>
<?php if(isset($_GET['success']) && $_GET['success'] == 'property_added'): ?>
<div class="alert alert-success">
    Property added successfully!
</div>
<?php endif; ?>
    <!-- MAIN CONTENT -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Real Estate Admin Dashboard</li>
                </ol>

                <div class="row">
                    <!-- Properties Card -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                <i class="fas fa-home"></i> Total Properties
                                <h3><?php echo $total_properties; ?></h3>
                            </div>
                        </div>
                    </div>
                    <!-- Users Card -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">
                                <i class="fas fa-users"></i> Total Users
                                <h3><?php echo $total_users; ?></h3>
                            </div>
                        </div>
                    </div>
                    <!-- Reservations Card -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">
                                <i class="fas fa-calendar-check"></i> Reservations
                                <h3><?php echo $total_reservations; ?></h3>
                            </div>
                        </div>
                    </div>
                    <!-- Blogs Card -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">
                                <i class="fas fa-blog"></i> Blogs
                                <h3><?php echo $total_blogs; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PIE CHART -->
                <div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-chart-pie me-1"></i>
        Most Viewed Properties
    </div>
    <div class="card-body">
        <div id="piechart" style="width: 100%; height: 400px;"></div>
    </div>
</div>

                <!-- RECENT RESERVATIONS TABLE -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Recent Reservations
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Client Name</th>
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
                                while($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                   <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                   <td><?php echo htmlspecialchars($row['email']); ?></td>
                                   <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                   <td><?php echo htmlspecialchars($row['property']); ?></td>
                                   <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                </tr>
                                <?php } $conn->close(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">© 2026 Real Estate Admin</div>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
<script type="text/javascript">
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
        title: 'Most Viewed Properties',
        pieHole: 0.35,
        chartArea: { width: '90%', height: '80%' },
        legend: { position: 'right' }
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
}
</script>
</script>
</body>
</html>