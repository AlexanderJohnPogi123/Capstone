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
<title>About Us | Iloilo Top Property Homes</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

<style>

body{
font-family:'Montserrat',sans-serif;
background:#f6f6f0;
margin:0;
}

/* Top Contact */

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

.navbar .navbar-brand{
font-weight:700;
font-size:1.5rem;
color:#bfa158;
}

.btn-reserve{
background:#bfa158;
border:none;
color:white;
padding:8px 20px;
border-radius:4px;
font-weight:600;
}

/* HERO */

.about-hero{
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

.about-hero::before{
content:'';
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.45);
}

.about-hero h1{
position:relative;
font-size:3rem;
font-weight:600;
}

/* About Section */

.about-section{
padding:80px 0;
}

.section-title{
color:#bfa158;
font-weight:700;
}

.icon-box{
background:white;
padding:30px;
border-radius:8px;
box-shadow:0 4px 10px rgba(0,0,0,0.08);
text-align:center;
height:100%;
}

.icon-box i{
font-size:2.5rem;
color:#bfa158;
margin-bottom:10px;
}

/* Team */

.team-card{
background:white;
padding:20px;
border-radius:8px;
text-align:center;
box-shadow:0 4px 10px rgba(0,0,0,0.08);
}

.team-card img{
width:100%;
height:250px;
object-fit:cover;
border-radius:6px;
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

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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

<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
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

<li class="nav-item">
<a class="nav-link" href="contact_us.php">Contact Us</a>
</li>

</ul>

<a href="reservation.php" class="btn btn-reserve">Reserve Now</a>

</div>
</div>
</nav>

<!-- HERO -->
<section class="about-hero">
<h1>About Us</h1>
</section>

<!-- ABOUT COMPANY -->
<section class="about-section">
<div class="container">

<div class="row align-items-center">

<div class="col-md-6">
<img src="../photo/image_7.jpg" class="img-fluid rounded shadow">
</div>

<div class="col-md-6">

<h2 class="section-title mb-3">Who We Are</h2>

<p>
Iloilo Top Property Homes is a real estate platform that showcases premium
subdivisions and residential properties in Iloilo. Our goal is to help families
find safe, modern, and comfortable homes in well-planned communities.
</p>

<p>
We provide reliable property listings, reservation services, and detailed
information about subdivisions to help buyers make the best investment
decisions.
</p>

</div>

</div>

</div>
</section>

<!-- MISSION VISION -->

<section class="about-section" style="background:white;">

<div class="container">

<div class="text-center mb-5">
<h2 class="section-title">Our Mission & Vision</h2>
</div>

<div class="row g-4">

<div class="col-md-6">

<div class="icon-box">
<i class="bi bi-bullseye"></i>
<h5>Our Mission</h5>
<p>
To provide accessible and trustworthy property information while helping
clients find the perfect home for their families.
</p>
</div>

</div>

<div class="col-md-6">

<div class="icon-box">
<i class="bi bi-eye"></i>
<h5>Our Vision</h5>
<p>
To become a trusted real estate platform in Iloilo that connects people
to quality homes and investment opportunities.
</p>
</div>

</div>

</div>

</div>

</section>

<!-- TEAM -->

<section class="about-section">

<div class="container">

<div class="text-center mb-5">
<h2 class="section-title">Our Team</h2>
</div>

<div class="row g-4">

<div class="col-md-4">
<div class="team-card">
<img src="../photo/image_4.jpg">
<h5 class="mt-3">Property Consultant</h5>
<p class="text-muted">Sales Specialist</p>
</div>
</div>

<div class="col-md-4">
<div class="team-card">
<img src="../photo/image_7.jpg">
<h5 class="mt-3">Marketing Manager</h5>
<p class="text-muted">Property Marketing</p>
</div>
</div>

<div class="col-md-4">
<div class="team-card">
<img src="../photo/image_4.jpg">
<h5 class="mt-3">Client Support</h5>
<p class="text-muted">Customer Assistance</p>
</div>
</div>

</div>

</div>

</section>

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
