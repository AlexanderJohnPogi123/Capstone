<?php
session_start();
require_once __DIR__ . '/../backends/config.php';
$conn = get_db_connection();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Property - Admin Panel</title>
    <link href="styles.css" rel="stylesheet" />
<script src="js/scripts.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="../admin_side/index.php">Admin Panel</a>
</nav>
<div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="../admin_side/index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">Control Panel  </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Properties
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                   <a class="nav-link" href="../backends/add-property.php">Upload</a>
                                    <a class="nav-link" href="../admin_side/update_properties.php">Update</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.php">Login</a>
                                            <a class="nav-link" href="register.php">Register</a>
                                            <a class="nav-link" href="password.php">Forgot Password</a>
                                        </nav>
                                    </div>  
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                           
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
           <?php 
                    if (isset($_SESSION['username'])) {
                        echo htmlspecialchars($_SESSION['username']);
                    } else {
                        echo "Guest";
                    }
                ?>
                    </div>
                </nav>
            </div>
<div id="layoutSidenav">
<div id="layoutSidenav_content">

<main>
<div class="container-fluid px-4">
    <h1 class="mt-4">Add New Property</h1>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-home me-1"></i>
            Property Information
        </div>

        <div class="card-body">

            <form action="../backends/admin_upload.php" method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label">Property Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
<div class="mb-3">
    <label class="form-label">Property Page</label>
    <select name="property_page" class="form-control" required>
        <option value="">Select Property Page</option>
        <option value="monticello">Monticello</option>
        <option value="parc_regency">Parc Regency</option>
        <option value="deca_homes">Deca Homes</option>
    </select>
</div>
                

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bedrooms</label>
                        <input type="number" name="bedrooms" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bathrooms</label>
                        <input type="number" name="bathrooms" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Property Image</label>
                  <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                </div>
                <div class="mb-3">
    <label class="form-label">Property Description</label>
    <textarea name="description" class="form-control" rows="5" placeholder="Enter property description" required></textarea>
</div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Add Property
                </button>

            </form>

        </div>
    </div>
</div>
</main>

<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4 text-center">
        <div class="text-muted small">Copyright &copy; 2026</div>
    </div>
</footer>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>