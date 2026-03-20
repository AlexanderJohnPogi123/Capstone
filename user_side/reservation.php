<?php
require_once '../backends/config.php';
require_once '../backends/submit_reservation.php';
$conn = get_db_connection();
$house = $_GET['house'] ?? '';
$property = $_GET['property_page'] ?? '';
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Property Reservation | Crown Asia Clone</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    font-family:'Montserrat',sans-serif;
    margin:0;
    background:#f6f6f0;
}

/* TOP CONTACT */
.top-contact{
    background:rgba(255,255,255,0.85);
    color:#333;
    font-size:0.85rem;
    padding:5px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    position:fixed;
    top:0;
    width:100%;
    z-index:1050;
}

/* NAVBAR */
.navbar{
    position:fixed;
    top:30px;
    width:100%;
    background:#f6f6f0;
    z-index:1040;
}

.navbar .nav-link{
    margin-left:25px;
}

.btn-reserve{
    background:#bfa158;
    color:#fff;
    padding:8px 20px;
    border-radius:4px;
    font-weight:600;
}

/* HERO BACKGROUND */
.hero{
    height:40vh;
    background-image:url('../photo/bg_2.jpg');
    background-size:cover;
    background-position:center;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    margin-top:60px;
}

.hero::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.4);
}

.hero-content{
    position:relative;
    z-index:2;
    text-align:center;
}

/* FORM CARD */
.card-reservation{
    border-radius:10px;
    box-shadow:0 3px 10px rgba(0,0,0,0.1);
}
</style>
</head>
<body>

<!-- Top Contact -->
<div class="top-contact">
    <div>info@crownasia.com.ph | (+63) 927 933 3923</div>
    <div>
        <i class="bi bi-facebook me-2"></i>
        <i class="bi bi-instagram me-2"></i>
        <i class="bi bi-youtube"></i>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
<div class="container">
    <a class="navbar-brand" href="index.php">ITPH</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav me-3">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Properties</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="monticello.php">Monticello</a></li>
            <li><a class="dropdown-item" href="parc_regency.php">Parc Regency</a></li>
            <li><a class="dropdown-item" href="deca_homes.php">Deca Homes Pavia</a></li>
        </ul>
       </li>
       <li class="nav-item"><a class="nav-link" href="#">Explore</a></li>
       <li class="nav-item dropdown position-static">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">News & Blogs</a>
        <div class="dropdown-menu w-100 p-4">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold"><i class="bi bi-newspaper"></i> Latest News</h6>
                    <p class="small text-muted">Stay updated with the latest real estate updates and announcements.</p>
                    <a href="news.php" class="btn btn-outline-primary btn-sm">View News</a>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold"><i class="bi bi-pencil-square"></i> Blogs</h6>
                    <p class="small text-muted">Helpful guides about buying homes and property investment.</p>
                    <a href="blogs.php" class="btn btn-outline-primary btn-sm">Read Blogs</a>
                </div>
            </div>
        </div>
       </li>
       <li class="nav-item"><a class="nav-link" href="contact_us.php">Contact Us</a></li>
      </ul>
      <a href="reservation.php" class="btn btn-reserve">Reserve Now</a>
    </div>
</div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1 class="fw-bold">Reserve Your Dream Home</h1>
        <p>Fill out the form below to schedule your property reservation.</p>
    </div>
</section>

<!-- Reservation Form -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card card-reservation p-4">
                <h3 class="mb-4">Reservation Form</h3>
                <form action="/recapstone/backends/submit_reservation.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="fullname" placeholder="Enter Your Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter Gmail" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" name="phone" placeholder="Enter Your Number" pattern="[0-9+ ]{10,15}" required>
                    </div>
                 <div class="mb-3">
<input type="text" class="form-control bg-light"
name="property_page"
value="<?php echo htmlspecialchars($house . ' - ' . $property); ?>"
readonly>
                    <div class="mb-3">
                        <label class="form-label">Preferred Date</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preferred Time</label>
                        <input type="time" class="form-control" name="time" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" required>
                        <label class="form-check-label">I agree to the terms and conditions</label>
                    </div>
                    <button type="submit" class="btn btn-reserve w-100 fw-bold">Reserve Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    
// Scroll effect: hide top contact
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    const topContact = document.querySelector('.top-contact');
    if(window.scrollY > 50){ 
        navbar.classList.add('scrolled'); 
        topContact.classList.add('hidden'); 
    } else { 
        navbar.classList.remove('scrolled'); 
        topContact.classList.remove('hidden'); 
    }
});
</script>
</body>
</html>