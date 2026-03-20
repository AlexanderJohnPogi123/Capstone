<?php
session_start();
require_once __DIR__ . '/../backends/config.php';
$conn = get_db_connection();

$currentPage = basename($_SERVER['PHP_SELF']);

// Fetch the top reserved property for Deca Homes
$topReservedQuery = $conn->query("
    SELECT property, COUNT(*) AS total_reserved
    FROM reservations
    WHERE property = 'Deca Homes Pavia'
    GROUP BY property
    ORDER BY total_reserved DESC
    LIMIT 1
");

$topReserved = $topReservedQuery->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Deca Homes Pavia</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

<style>

body{
font-family:'Montserrat',sans-serif;
background:#f6f6f0;
margin:0;
}

/* TOP CONTACT */
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
transition:.3s;
}

.top-contact.hidden{
transform:translateY(-100%);
opacity:0;
}

/* NAVBAR */
.navbar{
position:fixed;
top:30px;
width:100%;
background:transparent;
z-index:1040;
transition:.5s;
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

.navbar-brand{
font-weight:700;
font-size:1.5rem;
color:#bfa158;
}

.btn-reserve{
background:#bfa158;
color:white;
padding:8px 20px;
border-radius:4px;
font-weight:600;
border:none;
}

/* MAIN SECTION */
.main-section{
padding-top:140px;
padding-bottom:60px;
}

/* HERO MESSAGE ABOVE CONTENT */
.hero-message{
    max-width:50%;
    color:#bfa158;
    margin-bottom:40px;
}

.hero-message h1{
    font-size:2.5rem;
    font-weight:300;
    line-height:1.2;
}

.hero-message p{
    font-size:1rem;
    line-height:1.6;
    color:#7a6240;
}
/* LOCATION MENU */
.location-menu{
border-right:2px solid #e5e5e5;
padding-right:10px;
}

.location-menu a{
display:flex;
justify-content:space-between;
align-items:center;
padding:12px 10px;
text-decoration:none;
color:#333;
font-weight:500;
border-bottom:1px solid #eee;
transition:.3s;
}

.location-menu a:hover{
color:#bfa158;
}

.location-menu a.active{
color:#bfa158;
font-weight:600;
border-bottom:2px solid #bfa158;
}

.location-menu i{
opacity:0;
transition:.3s;
}

.location-menu a.active i{
opacity:1;
}

/* PROPERTY CARDS */
.property-card{
background:white;
border-radius:10px;
padding:20px;
box-shadow:0 3px 10px rgba(0,0,0,0.1);
transition:.3s;
}

.property-card:hover{
transform:translateY(-5px);
}

.property-card img{
width:100%;
height:220px;
object-fit:cover;
border-radius:8px;
}

.property-title{
color:#bfa158;
font-weight:600;
}
.carousel img{
height:450px;
object-fit:cover;
border-radius:10px;
}
.carousel-item {
    transition: transform 1s ease-in-out;
}
</style>

</head>

<body>

<!-- TOP CONTACT -->
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
        <li class="nav-item"><a class="nav-link" href="about_us.php">About Us</a></li>
       <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="propertiesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Properties
    </a>
    <ul class="dropdown-menu" aria-labelledby="propertiesDropdown">
        <li><a class="dropdown-item" href="monticello.php">Montimo</a></li>
        <li><a class="dropdown-item" href="parc_regency.php">Parc Regency</a></li>
        <li><a class="dropdown-item" href="deca_homes.php">Deca Homes Pavia</a></li>
    <a class="dropdown-item" href="top_properties.php">Top 10 Monthly Properties</a></li>
    </ul>
</li>
        <li class="nav-item"><a class="nav-link" href="#">Explore</a></li>
        <li class="nav-item dropdown position-static">
    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
        News & Blogs
    </a>

    <div class="dropdown-menu w-100 p-4">
        <div class="row">

            <div class="col-md-6">
                <h6 class="fw-bold">
                    <i class="bi bi-newspaper"></i> Latest News
                </h6>
                <p class="small text-muted">
                    Stay updated with the latest real estate updates and subdivision announcements.
                </p>
                <a href="news.php" class="btn btn-outline-primary btn-sm">View News</a>
            </div>

          <div class="col-md-6">
    <h6 class="fw-bold">
        <i class="bi bi-camera-video"></i> Vlogs
    </h6>

    <p class="small text-muted">
        Watch our latest property tours, real estate tips, and guides about buying homes and investing in property.
    </p>

    <a href="vlogs.php" class="btn btn-outline-primary btn-sm">
        Watch Vlogs
    </a>
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
<!-- MAIN CONTENT -->
 

<section class="main-section">
<div class="container">

<div class="row">

<!-- ✅ LEFT NAVIGATION BACK -->
<div class="col-md-2">
<div class="location-menu">

<a href="monticello.php" class="<?php if($currentPage=='monticello.php') echo 'active'; ?>">
Monticello
</a>

<a href="parc_regency.php" class="<?php if($currentPage=='parc_regency.php') echo 'active'; ?>">
Parc Regency
</a>

<a href="deca_homes.php" class="<?php if($currentPage=='deca_homes.php') echo 'active'; ?>">
Deca Homes
</a>

</div>
</div>

<!-- RIGHT CONTENT -->
<div class="col-md-10">
<div class="hero-message">
    <h1>Discover Deca Homes Pavia</h1>
    <p>
        Experience affordable and modern living in the heart of Pavia, Iloilo. 
        Deca Homes offers quality-built homes designed for comfort, convenience, 
        and a growing community perfect for families and future homeowners.
    </p>
</div>
<?php if($topReserved && $topReserved['total_reserved'] > 0): ?>
<div class="alert alert-warning mb-4">
Most Reserved: <?php echo $topReserved['property']; ?> 
(<?php echo $topReserved['total_reserved']; ?> reservations)
</div>
<?php endif; ?>

<div class="row g-4">

<?php
$result = $conn->query("SELECT * FROM propertiies WHERE property_page='deca_homes' ORDER BY id DESC");

if($result->num_rows > 0){
while($row = $result->fetch_assoc()){

$title = decrypt_data($row['title']);
$location = decrypt_data($row['location']);
$price = $row['price'];
$bedrooms = $row['bedrooms'];
$bathrooms = $row['bathrooms'];

// IMAGES
$images = [];
$imageQuery = $conn->prepare("SELECT image FROM property_images WHERE property_id=?");
$imageQuery->bind_param("i",$row['id']);
$imageQuery->execute();
$imageResult = $imageQuery->get_result();

while($img = $imageResult->fetch_assoc()){
    $images[] = decrypt_data($img['image']);
}

if(empty($images)){
    $images[] = decrypt_data($row['display_image']);
}

$carouselId = "carousel_" . $row['id'];
?>

<div class="col-md-4">
<div class="property-card">

<!-- CAROUSEL -->
<div id="<?php echo $carouselId; ?>" 
     class="carousel slide"
     data-bs-ride="carousel"
     data-bs-interval="2500"
     data-bs-pause="false">

<div class="carousel-inner">

<?php
$active = true;
foreach($images as $img){
?>

<div class="carousel-item <?php if($active){ echo 'active'; $active=false; } ?>">
<img src="../photo/uploads/<?php echo $img; ?>" class="d-block w-100">
</div>

<?php } ?>

</div>

<button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="prev">
<span class="carousel-control-prev-icon"></span>
</button>

<button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="next">
<span class="carousel-control-next-icon"></span>
</button>

</div>

<!-- DETAILS -->
<h5 class="property-title mt-3"><?php echo htmlspecialchars($title); ?></h5>
<p><strong>Price:</strong> ₱<?php echo number_format($price,2); ?></p>
<p><strong>Location:</strong> <?php echo htmlspecialchars($location); ?></p>
<p><?php echo $bedrooms; ?> Bed | <?php echo $bathrooms; ?> Bath</p>

<a href="reservation.php?house=<?php echo urlencode($title); ?>&property_page=Deca Homes" 
class="btn btn-warning w-100 mt-2">
Reserve Now
</a>

<a href="view_property.php?id=<?php echo $row['id']; ?>" 
class="btn btn-outline-dark w-100 mt-2">
View Property
</a>

</div>
</div>

<?php
}
}else{
echo "<p>No properties available.</p>";
}
?>

</div>
</div>

</div>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>