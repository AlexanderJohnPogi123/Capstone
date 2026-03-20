<?php
session_start();
require_once '../backends/config.php';

$conn = get_db_connection();

/* ADMIN LOGIN */
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

/* UPLOAD VLOG */
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

            header("Location: admin_blog_mangement.php");
            exit();
        }
    }
}

/* DELETE VLOG */
if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("DELETE FROM vlogs WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_blog_management.php");
    exit();
}

/* FETCH VLOGS */
$result = $conn->query("SELECT id, title, video_path, created_at FROM vlogs ORDER BY created_at DESC");

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
</head>
<body class="sb-nav-fixed">

<!-- NAVBAR -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.php">Real Estate Admin</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." />
            <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
        </div>
    </form>
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

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseProperties" aria-expanded="false">
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

                    <!--<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseReservations" aria-expanded="false">
                        <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                        Reservations
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>-->
                    <div class="collapse" id="collapseReservations" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="admin_reservation.php">Reserved List</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBlog" aria-expanded="false">
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

<div id="layoutSidenav_content">
<main>
<div class="container-fluid px-4">

<h1 class="mt-4">Vlog Management</h1>
<ol class="breadcrumb mb-4">
<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
<li class="breadcrumb-item active">Vlogs</li>
</ol>

<!-- Upload Card -->
<div class="card mb-4">
<div class="card-header">
<i class="fas fa-video me-1"></i>
Upload New Vlog
</div>

<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label class="form-label">Vlog Title</label>
<input type="text" name="title" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Upload Video</label>
<input type="file" name="video" class="form-control" accept="video/*" required>
</div>

<button type="submit" name="upload_vlog" class="btn btn-primary">
<i class="fas fa-upload"></i> Upload Vlog
</button>

</form>

</div>
</div>

<!-- Vlog Table -->
<div class="card mb-4">
<div class="card-header">
<i class="fas fa-table me-1"></i>
Uploaded Vlogs
</div>

<div class="card-body">

<table id="datatablesSimple">

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

<td><?php echo htmlspecialchars($row['title']); ?></td>

<td>
<video width="220" controls>
<source src="../uploads/vlogs/<?php echo $row['video_path']; ?>" type="video/mp4">
</video>
</td>

<td><?php echo htmlspecialchars($row['created_at']); ?></td>

<td>
<a href="admin_blog_management.php?delete=<?php echo $row['id']; ?>" 
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this vlog?');">
<i class="fas fa-trash"></i> Delete
</a>
</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>
</div>

</div>
</main>

<footer class="py-4 bg-light mt-auto">
<div class="container-fluid px-4">
<div class="d-flex align-items-center justify-content-between small">
<div class="text-muted">Copyright &copy; Real Estate 2026</div>
</div>
</div>
</footer>

</div>