```php
<?php
session_start();
require_once '../backends/config.php';
$conn = get_db_connection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us | Iloilo Top Property Homes</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

<style>

body{
font-family:'Montserrat',sans-serif;
margin:0;
background:#f6f6f0;
}

/* Top Contact (same as homepage) */

.top-contact{
background:rgba(255,255,255,0.8);
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
transition:0.3s;
}

.top-contact.hidden{
transform:translateY(-100%);
opacity:0;
}

.top-contact .social-icons a{
margin-left:15px;
color:#333;
}

/* Navbar */

.navbar{
position:fixed;
top:30px;
width:100%;
z-index:1040;
background:transparent;
transition:0.5s;
}

.navbar.scrolled{
top:0;
background:#f6f6f0;
box-shadow:0 2px 8px rgba(0,0,0,0.1);
}

.navbar .nav-link{
margin-left:25px;
color:#bfa158;
font-weight:500;
}

.navbar .btn-reserve{
background:#bfa158;
border:none;
color:#fff;
padding:8px 20px;
border-radius:4px;
font-weight:600;
}

.navbar .navbar-brand{
font-weight:700;
font-size:1.5rem;
color:#bfa158;
}

/* HERO */

.contact-hero{
height:60vh;
background-image:url('../photo/bg_2.jpg');
background-size:cover;
background-position:center;
display:flex;
align-items:center;
justify-content:center;
position:relative;
color:white;
}

.contact-hero::before{
content:'';
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.45);
}

.contact-hero h1{
position:relative;
font-size:3rem;
font-weight:600;
}

/* Contact Section */

.contact-section{
padding:80px 0;
}

.contact-card{
background:white;
padding:25px;
border-radius:8px;
text-align:center;
box-shadow:0 4px 10px rgba(0,0,0,0.08);
height:100%;
}

.contact-card i{
font-size:2rem;
color:#bfa158;
margin-bottom:10px;
}

/* Contact Form */

.contact-form{
background:white;
padding:40px;
border-radius:8px;
box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

.form-control{
margin-bottom:15px;
padding:12px;
}

.btn-gold{
background:#bfa158;
color:white;
border:none;
padding:12px 25px;
font-weight:600;
}

.btn-gold:hover{
background:#8c7a45;
}

</style>

</head>
<body>

<!-- Top Contact -->
<div class="top-contact">
<div>info@crownasia.com.ph | (+63) 927 933 3923</div>

<div class="social-icons">
<a href="#"><i class="bi bi-facebook"></i></a>
<a href="#"><i class="bi bi-twitter"></i></a>
<a href="#"><i class="bi bi-instagram"></i></a>
<a href="#"><i class="bi bi-youtube"></i></a>
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

<li class="nav-item">
<a class="nav-link" href="index.php">Home</a>
</li>

<li class="nav-item">
<a class="nav-link" href="about_us.php">About Us</a>
</li>

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
Properties
</a>

<ul class="dropdown-menu">
<li><a class="dropdown-item" href="monticello.php">Montimo</a></li>
<li><a class="dropdown-item" href="parc_regency.php">Parc Regency</a></li>
<li><a class="dropdown-item" href="deca_homes.php">Deca Homes Pavia</a></li>

</ul>

</li>

<li class="nav-item">
<a class="nav-link" href="#">Explore</a>
</li>

<li class="nav-item dropdown position-static">

<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
News & Blogs
</a>

<div class="dropdown-menu w-100 p-4">

<div class="row">

<div class="col-md-6">
<h6><i class="bi bi-newspaper"></i> Latest News</h6>
<p class="small text-muted">
Stay updated with the latest real estate updates.
</p>
<a href="news.php" class="btn btn-outline-primary btn-sm">View News</a>
</div>

<div class="col-md-6">
<h6><i class="bi bi-camera-video"></i> Vlogs</h6>
<p class="small text-muted">
Watch our latest property tours and guides.
</p>
<a href="vlogs.php" class="btn btn-outline-primary btn-sm">Watch Vlogs</a>
</div>

</div>

</div>

</li>

<li class="nav-item">
<a class="nav-link" href="contact_us.php">Contact Us</a>
</li>

</ul>

<a href="reservation.php" class="btn btn-reserve">Reserve Now</a>


</div>
</div>
</nav>

<!-- HERO -->
<section class="contact-hero">
<h1>Contact Us</h1>
</section>

<!-- CONTACT SECTION -->

<section class="contact-section">

<div class="container">

<div class="text-center mb-5">
<h2 style="color:#bfa158;font-weight:700;">Get in Touch</h2>
<p>Send us a message for property inquiries and reservations.</p>
</div>

<div class="row g-4 mb-5">

<div class="col-md-4">
<div class="contact-card">
<i class="bi bi-geo-alt"></i>
<h5>Location</h5>
<p>Pavia, Iloilo City</p>
</div>
</div>

<div class="col-md-4">
<div class="contact-card">
<i class="bi bi-telephone"></i>
<h5>Phone</h5>
<p>(+63) 927 933 3923</p>
</div>
</div>

<div class="col-md-4">
<div class="contact-card">
<i class="bi bi-envelope"></i>
<h5>Email</h5>
<p>info@crownasia.com.ph</p>
</div>
</div>

</div>

<div class="row">

<div class="col-md-6">

<div class="contact-form">

<h4 class="mb-4">Send Message</h4>

<form action="../backends/send_message.php" method="POST">

<input type="text" name="name" class="form-control" placeholder="Full Name" required>

<input type="email" name="email" class="form-control" placeholder="Email Address" required>

<input type="text" name="phone" class="form-control" placeholder="Phone Number">

<textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>

<button class="btn btn-gold">Send Message</button>

</form>

</div>

</div>

<div class="col-md-6">
<img src="../photo/image_7.jpg" class="img-fluid rounded shadow">
</div>

</div>

</div>

</section>
<!-- Google Map Section -->
<section class="map-section py-5" style="background:#f6f6f0;">
<div class="container">

<div class="text-center mb-4">
<i class="bi bi-geo-alt" style="font-size:3rem;color:#bfa158;"></i>
<h2 style="color:#bfa158;font-weight:700;">Find Us on the Map</h2>
<p class="text-muted">Visit our office or explore the location of our properties.</p>
</div>

<div class="map-container shadow rounded" style="overflow:hidden;">

<iframe
width="100%"
height="450"
style="border:0;"
loading="lazy"
allowfullscreen
referrerpolicy="no-referrer-when-downgrade"
src="https://www.google.com/maps?q=Iloilo+City&output=embed">
</iframe>

</div>

</div>
</section>

<!-- Scripts -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
window.addEventListener('scroll', () => {

const navbar = document.querySelector('.navbar');
const topContact = document.querySelector('.top-contact');

if(window.scrollY > 50){

navbar.classList.add('scrolled');
topContact.classList.add('hidden');

}else{

navbar.classList.remove('scrolled');
topContact.classList.remove('hidden');

}

});
</script>

</body>
</html>
```
