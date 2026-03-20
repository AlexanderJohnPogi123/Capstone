<?php
session_start();
require_once '../backends/config.php';
$conn = get_db_connection();

$result = $conn->query("SELECT * FROM vlogs ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Property Vlogs | Iloilo Top Property Homes</title>

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
transition:0.4s;
}

.navbar.scrolled{
top:0;
background:#f6f6f0;
box-shadow:0 2px 8px rgba(0,0,0,0.1);
}

.navbar .nav-link{
margin-left:25px;
color:#333;
font-weight:500;
}

.navbar-brand{
font-weight:700;
font-size:1.5rem;
color:#bfa158;
}

.btn-reserve{
background:#bfa158;
border:none;
color:#fff;
padding:8px 20px;
border-radius:4px;
font-weight:600;
}

/* Vlog Section */

.vlog-section{
padding:80px 0;
background:#f6f6f0;
}

.section-title{
text-align:center;
margin-bottom:50px;
}

.section-title i{
font-size:3rem;
color:#bfa158;
}

.section-title h2{
color:#bfa158;
font-weight:700;
margin-top:10px;
}

.vlog-card{
border:none;
border-radius:10px;
overflow:hidden;
box-shadow:0 5px 15px rgba(0,0,0,0.08);
transition:0.3s;
background:white;
}

.vlog-card:hover{
transform:translateY(-8px);
box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.vlog-video video{
width:100%;
height:220px;
object-fit:cover;
}

.vlog-card .card-body{
padding:18px;
}

.vlog-title{
font-weight:600;
}

.vlog-date{
font-size:0.85rem;
color:#888;
}
/* Vlogs Hero Banner */

.vlog-hero{
height:50vh;
background-image:url('../photo/bg_2.jpg');
background-size:cover;
background-position:center;
display:flex;
align-items:center;
justify-content:center;
color:white;
position:relative;
text-align:center;
}

.vlog-hero::before{
content:'';
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.45);
}

.vlog-hero-content{
position:relative;
z-index:2;
}

.vlog-hero h1{
font-size:3rem;
font-weight:600;
}

.vlog-hero p{
font-size:1.1rem;
}

</style>
</head>

<body>

<!-- Top Contact -->
<div class="top-contact">
<div>info@crownasia.com.ph | (+63) 927 933 3923</div>

<div class="social-icons">
<a href="#"><i class="bi bi-facebook"></i></a>
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

<li class="nav-item">
<a class="nav-link" href="#">Properties</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#">Explore</a>
</li>

<li class="nav-item">
<a class="nav-link active" href="vlogs.php">Vlogs</a>
</li>

<li class="nav-item">
<a class="nav-link" href="contact_us.php">Contact</a>
</li>

</ul>

<a href="reservation.php" class="btn btn-reserve">Reserve Now</a>

</div>
</div>
</nav>
<section class="vlog-hero">

<div class="vlog-hero-content">

<h1>Property Vlogs</h1>

<p>Watch property tours, investment tips, and real estate guides in Iloilo.</p>

</div>

</section>

<!-- Vlog Section -->
<section class="vlog-section">

<div class="container">

<div class="section-title">
<i class="bi bi-camera-video"></i>
<h2>Latest Property Vlogs</h2>
<p>Watch our property tours and real estate tips.</p>
</div>

<div class="row g-4">

<?php while($row = $result->fetch_assoc()): ?>

<div class="col-lg-4 col-md-6">

<div class="card vlog-card">

<div class="vlog-video">
<video controls>
<source src="../uploads/vlogs/<?php echo $row['video_path']; ?>" type="video/mp4">
</video>
</div>

<div class="card-body">

<h6 class="vlog-title">
<?php echo htmlspecialchars($row['title']); ?>
</h6>

<div class="vlog-date">
<i class="bi bi-calendar"></i>
<?php echo date("F d, Y", strtotime($row['created_at'])); ?>
</div>

</div>
</div>

</div>

<?php endwhile; ?>

</div>

</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>

window.addEventListener('scroll',function(){
const navbar=document.querySelector('.navbar');

if(window.scrollY>50){
navbar.classList.add('scrolled');
}else{
navbar.classList.remove('scrolled');
}

});

</script>

</body>
</html>

<?php $conn->close(); ?>