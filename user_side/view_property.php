<?php
session_start();
require_once __DIR__ . '/../backends/config.php';
$conn = get_db_connection();

if(!isset($_GET['id'])){
die("Property not found.");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM propertiies WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$title = decrypt_data($row['title']);
$location = decrypt_data($row['location']);
$description = decrypt_data($row['description']); // <- decrypt here

$type = $row['type'];
$price = $row['price'];
$bedrooms = $row['bedrooms'];
$bathrooms = $row['bathrooms'];

/* FETCH IMAGES */
$images = [];
$imageQuery = $conn->prepare("SELECT image FROM property_images WHERE property_id=?");
$imageQuery->bind_param("i",$id);
$imageQuery->execute();
$imageResult = $imageQuery->get_result();

while($img = $imageResult->fetch_assoc()){
$images[] = decrypt_data($img['image']);
}
if (!isset($_SESSION['viewed_' . $id])) {

    $stmt = $conn->prepare("UPDATE propertiies SET views = views + 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['viewed_' . $id] = true;
}
?>


<!DOCTYPE html>
<html>
<head>

<title><?php echo htmlspecialchars($title); ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f6f6f0;
font-family:'Montserrat',sans-serif;


}
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



.property-section{
    padding-top:140px;
    padding-bottom:80px;
}
.property-title{
color:#bfa158;
font-weight:700;
}

.carousel img{
height:450px;
object-fit:cover;
border-radius:10px;
}
.carousel-item {
    transition: transform 1s ease-in-out;
}


.details-box{
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 3px 10px rgba(0,0,0,0.1);
}

.btn-reserve{
background:#bfa158;
color:white;
border:none;
padding:10px 25px;
font-weight:600;
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

<!-- NAVBAR -->
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

        <!-- PROPERTIES DROPDOWN -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                Properties
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="monticello.php">Montimo</a></li>
                <li><a class="dropdown-item" href="parc_regency.php">Parc Regency</a></li>
                <li><a class="dropdown-item" href="deca_homes.php">Deca Homes</a></li>
                <li><a class="dropdown-item" href="top_properties.php">Top 10 Monthly Properties</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">Explore</a>
        </li>

        <!-- NEWS & BLOGS -->
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
                            Stay updated with real estate news.
                        </p>
                        <a href="news.php" class="btn btn-outline-primary btn-sm">View News</a>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold">
                            <i class="bi bi-camera-video"></i> Vlogs
                        </h6>
                        <p class="small text-muted">
                            Watch property tours and guides.
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

<section class="property-section">

<div class="container">

<div class="row g-5">

<!-- IMAGE CAROUSEL -->
<div class="col-md-6">

<div id="propertyCarousel" 
     class="carousel slide" 
     data-bs-ride="carousel" 
     data-bs-interval="2500" 
     data-bs-pause="false" 
     data-bs-wrap="true">

<div class="carousel-inner">

<?php
$active = true;
foreach($images as $img){
?>

<div class="carousel-item <?php if($active){echo 'active'; $active=false;} ?>">

<img src="../photo/uploads/<?php echo $img; ?>" class="d-block w-100">

</div>

<?php } ?>

</div>

<button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
<span class="carousel-control-prev-icon"></span>
</button>

<button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
<span class="carousel-control-next-icon"></span>
</button>

</div>

</div>

<!-- PROPERTY DETAILS -->
<div class="col-md-6">

<div class="details-box">

<h2 class="property-title"><?php echo htmlspecialchars($title); ?></h2>

<p><strong>Type:</strong> <?php echo htmlspecialchars($type); ?></p>

<p><strong>Price:</strong> ₱<?php echo number_format($price,2); ?></p>

<p><strong>Location:</strong> <?php echo htmlspecialchars($location); ?></p>

<p><?php echo $bedrooms; ?> Bedrooms | <?php echo $bathrooms; ?> Bathrooms</p>

<hr>

<div class="mt-4">
    <h5>Description</h5>
    <p><?php echo htmlspecialchars($description); ?></p>
</div>

<a href="reservation.php?house=<?php echo urlencode($title); ?>" class="btn btn-reserve mt-3">
Reserve Property
</a>

</div>

</div>

</div>

</div>


</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
window.addEventListener('scroll',()=>{
const navbar=document.querySelector('.navbar');
const topContact=document.querySelector('.top-contact');

if(window.scrollY>50){
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