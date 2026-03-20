<?php
session_start();
require_once __DIR__ . '/../backends/config.php';

$conn = get_db_connection();

// Check if admin is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Handle Update Property
if (isset($_POST['update_property'])) {

    $id = intval($_POST['id']);
    $price = floatval($_POST['price']);

    // Update with image
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
            die("Image upload failed.");
        }

        $encryptedImage = encrypt_data($imageName);

        $stmt = $conn->prepare("UPDATE propertiies SET price=?, image=? WHERE id=?");
        $stmt->bind_param("dsi",$price,$encryptedImage,$id);

    } 
    else {

        // Update price only
        $stmt = $conn->prepare("UPDATE propertiies SET price=? WHERE id=?");
        $stmt->bind_param("di",$price,$id);

    }

    $stmt->execute();
    $stmt->close();

    header("Location: update_properties.php?updated=1");
    exit;
}

// Handle Delete Property
if (isset($_POST['delete_property'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM propertiies WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: update_properties.php");
    exit;
}

// Fetch all properties
$properties_result = $conn->query("SELECT * FROM propertiies ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Update Properties - Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">

<!-- NAVBAR -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.php">Real Estate Admin</a>
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
                    <div class="sb-sidenav-menu-heading">Properties</div>
                    <a class="nav-link" href="../backends/add-property.php">Upload Property</a>
                    <a class="nav-link" href="update_properties.php">Update Properties</a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?php echo htmlspecialchars($_SESSION['username']); ?>
            </div>
        </nav>
    </div>

    <!-- MAIN CONTENT -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Update Properties</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Update Properties</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-table me-1"></i> All Properties</div>
                    <div class="card-body">
                        <?php if ($properties_result->num_rows == 0): ?>
                            <p>No properties found.</p>
                        <?php else: ?>
                        <table class="table table-bordered">
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
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <td>
                                            <?php echo $row['id']; ?>
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        </td>
                                        <td>
                                            <input type="text" name="property_name" class="form-control"
                                                   <input type="text" class="form-control"
value="<?php echo htmlspecialchars(decrypt_data($row['title'])); ?>" readonly>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" name="price" class="form-control"
                                                   value="<?php echo $row['price']; ?>" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control"
value="<?php echo htmlspecialchars(decrypt_data($row['location'])); ?>" readonly>
                                        </td>
                                        <td>
                                            <input type="file" name="image" class="form-control">
                                        </td>
                                        <td>
                                            <button type="submit" name="update_property" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i> Update
                                            </button>
                                            <button type="submit" name="delete_property" class="btn btn-danger btn-sm" onclick="return confirm('Delete this property?');">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
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
</body>
</html>