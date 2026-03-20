<?php
session_start();
require_once '../backends/config.php';
$conn = get_db_connection();

if (!isset($_SESSION['visitor_counted'])) {

    // Get visitor IP
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    // Get browser info
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';

    // Insert visitor record
    $stmt = $conn->prepare("INSERT INTO userss (ip_address, user_agent) VALUES (?, ?)");
    $stmt->bind_param("ss", $ip, $agent);
    $stmt->execute();
    $stmt->close();

    // Mark session so it won't count again
    $_SESSION['visitor_counted'] = true;
}

// Get total visitors
$result = $conn->query("SELECT COUNT(*) AS total FROM userss");
$total_visitors = $result->fetch_assoc()['total'];




?>

   
    
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iloilo Top Property Homes</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

<!-- AOS for scroll animations -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
body {
    font-family: 'Montserrat', sans-serif;
    margin: 0;
}

/* Top Contact */
.top-contact {
    background: rgba(255,255,255,0.8);
    color: #333;
    font-size: 0.85rem;
    padding: 5px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1050;
    transition: transform 0.3s ease, opacity 0.3s ease;
}
.top-contact.hidden {
    transform: translateY(-100%);
    opacity: 0;
}
.top-contact .social-icons a { margin-left: 15px; color:#333; }

/* Navbar */
.navbar {
    position: fixed;
    top: 30px;
    width: 100%;
    z-index: 1040;
    background: transparent;
    transition: top 0.5s ease, background 0.5s ease, box-shadow 0.5s ease;
}
.navbar.scrolled {
    top: 0;
    background: #f6f6f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.navbar .nav-link { margin-left: 25px; color:#bfa158; font-weight: 500; }
.navbar .btn-reserve { background: #bfa158; border: none; color: #fff; padding:8px 20px; border-radius:4px; font-weight:600; }
.navbar .navbar-brand { font-weight: 700; font-size: 1.5rem; color: #bfa158; text-decoration: none; }

/* Hero */
.hero {
    height: 100vh;
    background-image: url('../photo/bg_2.jpg');
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: center;
    color: white;
}
.property-search {
    margin-top: 20px;
    display: flex;
    color: #8c7a45;
    background: #f6f6f0;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}
.property-search select {
    border: none;
    padding: 12px;
    flex: 1;
}
.property-search button {
    background: #bfa158;
    color: #f6f6f0;
    border: none;
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.hero-overlay { position:absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.35); }
.hero-content { position: relative; z-index: 2; padding-left: 60px; max-width: 500px; }
.hero-content h1 { font-size: 3rem; font-weight:500; margin-bottom:20px; }
.hero-content p { font-size:1.1rem; margin-bottom:25px; }

/* Carousel - main highlight carousel */
.properties-carousel-section { display:flex; flex-direction:column; }

.carousel-slide {
    display: none;
    flex-direction: row;
    width: 100%;
    height: 400px;
}
.carousel-slide.active { display: flex; }

.highlight-text {
    flex:1;
    padding:40px 60px;
    display:flex;
    flex-direction: column;
    justify-content: flex-start;
    background:#f6f6f0;
    position: relative;
}
.highlight-text .subtitle { font-size:0.9rem; text-transform:uppercase; color:#3a3a50; letter-spacing:1px; }
.highlight-text .title { font-size:2.5rem; color:#bfa158; font-weight:600; margin:15px 0; }
.highlight-text .description { font-size:1rem; color:#3a3a50; margin-bottom:25px; }

.highlight-text .carousel-dots {
    position: absolute;
    bottom: 30px;
    left: 60px;
}

.carousel-dots span {
    display:inline-block; width:14px; height:14px; border-radius:50%; background:#bfa158; margin-right:8px; cursor:pointer;
}
.carousel-dots span.active { background:#8c7a45; }

.highlight-image { flex:1; overflow:hidden; }
.highlight-image img {
    width:100%;
    height:100%;
    object-fit:cover;
}

/* Features Section */
#features-section {
    padding: 80px 0;
    background: #f6f6f0;
}
#features-section .section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #bfa158;
}
#features-section .section-subtitle {
    font-size: 1.1rem;
    color: #3a3a50;
    margin-bottom: 50px;
}
.feature-card h5 { font-weight: 600; color: #333; }
.feature-card p { font-size: 0.95rem; color: #555; }
#features-section .logo-text { font-size: 2rem; font-weight: 700; color: #bfa158; margin-bottom: 20px; }

/* New Properties Carousel */
#newPropertiesCarousel {
    background:#f6f6f0;
    padding:30px 0;
}
#newPropertiesCarousel .carousel-item img {
    width: 560px;
    height: 408px;
    object-fit: cover;
    border-radius: 8px;
    margin: 0 auto;
}
#newPropertiesCarousel .carousel-item .btn {
    display: inline-block;
    background: transparent;
    color: #bfa158;
    font-weight: 600;
    padding: 12px 25px;
    border: 2px solid #bfa158;
    border-radius: 5px;
    text-transform: uppercase;
    font-size: 1rem;
    transition: 0.3s ease;
    text-decoration: none;
    margin-top: 10px;
}
#newPropertiesCarousel .carousel-item .btn:hover {
    background: #bfa158;
    color: white;
    border-color: #bfa158;
}
#newPropertiesCarousel .carousel-caption-container { text-align:center; margin-top:15px; }

/* Center-focused carousel effect */
#newPropertiesCarousel .carousel-item img {
    transform: scale(0.95);
    transition: transform 0.5s ease;
}
#newPropertiesCarousel .carousel-item.active img {
    transform: scale(1);
}

/* Responsive */
@media(max-width:768px){
    .hero-content { padding-left:30px; max-width:90%; }
    .hero-content h1 { font-size:2rem; }
    .carousel-slide { flex-direction: column; height:auto; }
    .highlight-image { width:100%; height:250px; margin-top:20px; }
    .highlight-text { padding:20px; }
    .highlight-text .carousel-dots { left:20px; bottom:20px; }

    #newPropertiesCarousel .carousel-item img { width:100%; height:auto; }
}

.title{
    color: #8c7a45;
    color: #bfa158;      /* Golden color */
    font-weight: bold;    /* Bold text */
    font-size: 1.2rem;   /* Optional: text size */
}
/* ================= LOADER ================= */

#loader {
    position: fixed;
    width: 100%;
    height: 100vh;
    background: #f6f6f0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 99999;
    transition: opacity 0.5s ease;
}

/* Hide everything while loading */
body.loading > *:not(#loader) {
    visibility: hidden;
}

.house {
    position: relative;
    width: 120px;
    height: 100px;
    margin-bottom: 20px;
    animation: bounce 1.5s infinite ease-in-out;
}

.roof {
    position: absolute;
    width: 0;
    height: 0;
    border-left: 60px solid transparent;
    border-right: 60px solid transparent;
    border-bottom: 60px solid #bfa158;
    top: -50px;
}

.body-house {
    width: 120px;
    height: 80px;
    background: white;
    border: 3px solid #d6d1c7;
    position: absolute;
    bottom: 0;
}

.door {
    width: 30px;
    height: 45px;
    background: #8c7a45;
    position: absolute;
    bottom: 0;
    left: 45px;
    border-radius: 4px 4px 0 0;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.loading-text {
    font-size: 18px;
    color: #8c7a45;
    margin-bottom: 15px;
    font-weight: 600;
}

.progress-bar {
    width: 200px;
    height: 8px;
    background: #ddd;
    border-radius: 10px;
    overflow: hidden;
}

.progress {
    width: 0%;
    height: 100%;
    background: #bfa158;
    animation: load 2.5s forwards;
}

@keyframes load {
    from { width: 0%; }
    to { width: 100%; }
}
/* --- NEW CUSTOM CHAT STYLES --- */
#chat-bubble {
    position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px;
    background: #bfa158; color: white; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    z-index: 2000; transition: transform 0.3s ease;
}
#chat-bubble:hover { transform: scale(1.1); }
#chat-window {
    position: fixed; bottom: 100px; right: 30px; width: 350px; height: 500px;
    background: white; border-radius: 15px; box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    display: none; flex-direction: column; overflow: hidden; z-index: 2000; border: 1px solid #ddd;
}
.chat-header { background: #bfa158; color: white; padding: 15px; font-weight: bold; display: flex; justify-content: space-between; align-items: center; }
#chat-messages { flex: 1; padding: 15px; overflow-y: auto; background: #fdfdfb; display: flex; flex-direction: column; gap: 10px; }
.msg { padding: 10px 14px; border-radius: 12px; max-width: 80%; font-size: 0.9rem; line-height: 1.4; }
.msg-user { align-self: flex-end; background: #bfa158; color: white; border-bottom-right-radius: 2px; }
.msg-bot { align-self: flex-start; background: #f1f1f1; color: #333; border-bottom-left-radius: 2px; }
.chat-input-area { padding: 15px; border-top: 1px solid #eee; display: flex; background: white; }
.chat-input-area input { flex: 1; border: 1px solid #ddd; padding: 10px; border-radius: 5px; outline: none; }
.chat-input-area button { background: none; border: none; color: #bfa158; font-size: 1.4rem; margin-left: 10px; cursor: pointer; }
</style>
</head>
<body>
    <div id="loader">
    <div class="house">
        <div class="roof"></div>
        <div class="body-house"></div>
        <div class="door"></div>
    </div>
    <div class="loading-text">Loading Properties...</div>
    <div class="progress-bar">
        <div class="progress"></div>
    </div>
</div>

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
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about_us.php">About Us</a></li>
       <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="propertiesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Properties
    </a>
    <ul class="dropdown-menu" aria-labelledby="propertiesDropdown">
        <li><a class="dropdown-item" href="monticello.php">Montimo</a></li>
        <li><a class="dropdown-item" href="parc_regency.php">Parc Regency</a></li>
        <li><a class="dropdown-item" href="deca_homes.php">Deca Homes Pavia</a></li>
    
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
      <a href="reservation2.php" class="btn btn-reserve">Reserve Now</a>
    </div>
  </div>
</nav>

<!-- Hero Section with Search -->
<section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Bringing quality living closer to your future.</h1>
        <p>Iloilo Top Property Homes presents beautiful houses within well-planned subdivisions in Iloilo, providing a safe environment and modern living for homeowners.</p>

        <form class="property-search" action="redirect.php" method="GET">

            <select name="property" required>
            <option disabled selected>Select Property</option>
            <option value="monticello.php">Monticello</option>
            <option value="parc_regency.php">Parc Regency</option>
            <option value="deca_homes.php">Deca Homes Pavia</option>
            </select>

            <button type="submit">
            <i class="bi bi-search"></i>
            </button>

            </form>
</section>
<div id="chat-bubble" onclick="toggleChat()">
    <i class="bi bi-chat-dots-fill"></i>
</div>

<div id="chat-window">
    <div class="chat-header">
        <span><i class="bi bi-house-heart"></i> ITPH Assistant</span>
        <i class="bi bi-x-lg" style="cursor:pointer" onclick="toggleChat()"></i>
    </div>
    <div id="chat-messages">
        <div class="msg msg-bot">Hello! I am your Iloilo Top Property Homes assistant. How can I help you today?</div>
    </div>
    <div class="chat-input-area">
        <input type="text" id="user-input-field" placeholder="Ask about properties..." onkeypress="if(event.key === 'Enter') sendChat()">
        <button onclick="sendChat()"><i class="bi bi-send-fill"></i></button>
    </div>
</div>

<!-- Main Carousel -->
<section class="properties-carousel-section">
    <div class="pcs-overlay"></div>

  <!-- Slide 1 -->
  <div class="carousel-slide active">
      <div class="highlight-text">
          <span class="subtitle">House and Lot Properties</span>
          <h2 class="title">Crown Asia's Horizontal Collection</h2>
          <p class="description">For 25 Years, Crown Asia remains committed to providing a good life and building premium thematic communities.</p>
          <div class="carousel-dots">
              <span class="dot active" data-index="0"></span>
              <span class="dot" data-index="1"></span>
          </div>
      </div>
      <div class="highlight-image">
          <img src="../photo/image_7.jpg" alt="House and Lot">
      </div>
  </div>

  <!-- Slide 2 -->
  <div class="carousel-slide">
      <div class="highlight-text">
          <span class="subtitle">Condominium Properties</span>
          <h2 class="title">Crown Asia's Vertical Collection</h2>
          <p class="description">Modern, premium condominiums in prime locations for a luxurious city lifestyle.</p>
          <div class="carousel-dots">
              <span class="dot" data-index="0"></span>
              <span class="dot active" data-index="1"></span>
          </div>
      </div>
      <div class="highlight-image">
          <img src="../photo/image_4.jpg" alt="Condominium">
      </div>
  </div>

</section>

<!-- Our Services Section -->
<section id="features-section">
    <div class="container text-center">
        <div class="logo-text" data-aos="fade-up">
            <i class="bi bi-tools" style="font-size: 3rem; color:#bfa158;"></i>
        </div>
        <h2 class="section-title mb-3" data-aos="fade-up" data-aos-duration="1000">Our Services</h2>
        <p class="section-subtitle mb-5" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="200">
            Explore the services and benefits we provide to make your experience unforgettable.
        </p>
        <div class="row g-4">
            <div class="col-md-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <div class="feature-card p-4 bg-white rounded shadow-sm h-100">
                    <div class="icon mb-3"><i class="bi bi-geo-alt fs-2 text-warning"></i></div>
                    <h5 class="mb-2">Global Locations</h5>
                    <p>Find properties and services anywhere across the world, curated for you.</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                <div class="feature-card p-4 bg-white rounded shadow-sm h-100">
                    <div class="icon mb-3"><i class="bi bi-person-check fs-2 text-warning"></i></div>
                    <h5 class="mb-2">Trusted Agents</h5>
                    <p>Professional agents ready to assist you in finding your dream property.</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
                <div class="feature-card p-4 bg-white rounded shadow-sm h-100">
                    <div class="icon mb-3"><i class="bi bi-building fs-2 text-warning"></i></div>
                    <h5 class="mb-2">Premium Properties</h5>
                    <p>Modern and luxurious properties to fit your lifestyle and taste.</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000">
                <div class="feature-card p-4 bg-white rounded shadow-sm h-100">
                    <div class="icon mb-3"><i class="bi bi-cash-stack fs-2 text-warning"></i></div>
                    <h5 class="mb-2">Investment Opportunities</h5>
                    <p>Grow your wealth with our exclusive property investment options.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- New Properties Carousel Section -->
<section class="properties-carousel-section py-5" style="background:#f6f6f0;">
  <div class="container">
    <div class="text-center mb-4">
        <i class="bi bi-house-door" style="font-size:3rem; color:#bfa158;"></i>
        <h2 class="section-title" style="color:#bfa158; font-weight:700;">Available Properties</h2>
    </div>

    <div id="newPropertiesCarousel" class="carousel slide carousel-dark" data-bs-ride="carousel">
      <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active">
          <img src="../photo/image_7.jpg" class="d-block" alt="House and Lot">
          <div class="text-center mt-3">
            <span class="subtitle text-uppercase">House and Lot Properties</span>
            <h3 class="title">Pavia, Iloilo City 5002</h3>
            <p>3 Bedroom | 2 Toilet | 1 Car Garage</p>
            <a href="#" class="btn">View All Properties</a>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
          <img src="../photo/image_4.jpg" class="d-block" alt="Condominium">
          <div class="text-center mt-3">
            <span class="subtitle text-uppercase">Condominium Properties</span>
            <h3 class="title">2 Bedroom Condo MegaWorld</h3>
            <p>1 Bedroom 23.22 sqm | With Balcony | Amenity View | Free Pool Access</p>
            <a href="#" class="btn">View All Properties</a>
          </div>
        </div>

      </div>

      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#newPropertiesCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#newPropertiesCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ once:true });

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

// Carousel dots click
const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.dot');
dots.forEach(dot => {
    dot.addEventListener('click', () => {
        const index = parseInt(dot.dataset.index);
        slides.forEach(s => s.classList.remove('active'));
        slides[index].classList.add('active');
        slides.forEach(sl => sl.querySelectorAll('.dot').forEach(d=>d.classList.remove('active')));
        dot.classList.add('active');
    });
});
</script>
<script>
document.body.classList.add("loading");

window.addEventListener("load", function () {
    setTimeout(function () {
        const loader = document.getElementById("loader");
        loader.style.opacity = "0";

        setTimeout(function () {
            loader.style.display = "none";
            document.body.classList.remove("loading");
        }, 500);

    }, 0); // Loading duration
});
</script>
<script>
AOS.init({ once:true });

// Chat Window Toggle
function toggleChat() {
    const chatWin = document.getElementById('chat-window');
    chatWin.style.display = (chatWin.style.display === 'flex') ? 'none' : 'flex';
}

// Send Message to PHP Backend
async function sendChat() {
    const inputField = document.getElementById('user-input-field');
    const chatMessages = document.getElementById('chat-messages');
    const message = inputField.value.trim();

    if (!message) return;

    // Display User Message
    chatMessages.innerHTML += `<div class="msg msg-user">${message}</div>`;
    inputField.value = '';
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Display Loading Placeholder
    const loadingId = "loading-" + Date.now();
    chatMessages.innerHTML += `<div class="msg msg-bot" id="${loadingId}">Typing...</div>`;
    chatMessages.scrollTop = chatMessages.scrollHeight;

    try {
        const formData = new FormData();
        formData.append('message', message);

        // Make sure backends/chat.php exists!
        const response = await fetch('../backends/chat.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        
        document.getElementById(loadingId).innerText = data.reply;
    } catch (error) {
        document.getElementById(loadingId).innerText = "I'm sorry, I'm having trouble connecting. Please try again later.";
    }
    chatMessages.scrollTop = chatMessages.scrollHeight;
}
</script>

</body>
</html>