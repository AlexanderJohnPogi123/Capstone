<?php
session_start();
require_once ('backends/config.php');

$conn = get_db_connection();

/* VISITOR COUNT */
if (!isset($_SESSION['visitor_counted'])) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';

    $stmt = $conn->prepare("INSERT INTO userss (ip_address, user_agent) VALUES (?, ?)");
    $stmt->bind_param("ss", $ip, $agent);
    $stmt->execute();
    $stmt->close();

    $_SESSION['visitor_counted'] = true;
}

/* FETCH PROPERTIES (FIXED TABLE NAME) */
/* FETCH PROPERTIES - CORRECTED */
/* FETCH PROPERTIES WITH IMAGE DATA */
$properties = [];
$query = "SELECT * FROM propertiies ORDER BY created_at DESC LIMIT 3";
$result = $conn->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Parse multiple images if stored as JSON or comma-separated
        $row['gallery_images'] = [];
        if (!empty($row['image'])) {
            // If JSON
            $gallery = json_decode($row['image'], true);
            if (is_array($gallery)) {
                $row['gallery_images'] = $gallery;
            } else {
                // If comma-separated
                $row['gallery_images'] = explode(',', $row['image']);
            }
        }
        $properties[] = $row;
    }
}

/* VISITOR COUNT */
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
<link rel="stylesheet" href="user_side/css/common.css">
<link rel="stylesheet" href="user_side/css/index.css">

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
    <div>ITPH.com.ph | (+63) 9123456789</div>
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
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="user_side/about_us.php">About Us</a></li>
      <li class="nav-item"><a class="nav-link" href="user_side/all_properties.php"> Properties</a></li>
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
                <a href="user_side/news.php" class="btn btn-outline-primary btn-sm">View News</a>
            </div>

          <div class="col-md-6">
    <h6 class="fw-bold">
        <i class="bi bi-camera-video"></i> Vlogs
    </h6>

    <p class="small text-muted">
        Watch our latest property tours, real estate tips, and guides about buying homes and investing in property.
    </p>

    <a href="user_side/vlogs.php" class="btn btn-outline-primary btn-sm">
        Watch Vlogs
    </a>
</div>

        </div>
    </div>
</li>
        
      </ul>
      <a href="user_side/contact_us.php" class="btn btn-reserve">Reach Us</a>
    </div>
  </div>
</nav>

<!-- Hero Section with Search -->
<section class="hero">
    <img src="photo/nbg.jpg" alt="" class="hero-img">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Bringing quality living closer to your future.</h1>
        <p>Iloilo Top Property Homes presents beautiful houses within well-planned subdivisions in Iloilo, providing a safe environment and modern living for homeowners.</p>

        <form class="property-search" action="user_side/redirect.php" method="GET">

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
          <h2 class="title">Daniella Intimo Collection</h2>
          <p class="description">Monticello Intimo remains committed to providing a good life and building premium thematic communities.</p>
          <div class="carousel-dots">
              <span class="dot active" data-index="0"></span>
              <span class="dot" data-index="1"></span>
          </div>
      </div>
      <div class="highlight-image">
          <img src="photo/daniella_i.png" alt="House and Lot">
      </div>
  </div>

  <!-- Slide 2 -->
  <div class="carousel-slide">
      <div class="highlight-text">
          <span class="subtitle">HOUSE AND LOT PROPERTIES</span>
          <h2 class="title">ALICE INTIMO COLLECTION</h2>
          <p class="description">Modern, premium houses in prime locations for a luxurious city lifestyle.</p>
          <div class="carousel-dots">
              <span class="dot" data-index="0"></span>
              <span class="dot active" data-index="1"></span>
          </div>
      </div>
      <div class="highlight-image">
          <img src="photo/rsv_bg.png" alt="Condominium">
      </div>
  </div>

</section>

<!-- Our Services Section -->
<section id="features-section">
    <div class="container text-center">
        <div class="logo-text" data-aos="">
            <i class="bi bi-tools" style="font-size: 3rem; color:#bfa158;"></i>
        </div>
        <h2 class="section-title mb-3" data-aos="fade-up" data-aos-duration="1000">Our Services</h2>
        <p class="section-subtitle mb-5" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="200">
            Explore the services and benefits we provide to make your experience unforgettable.
        </p>
        <div class="row g-3 justify-content-center"> <!-- Added justify-content-center -->
            <div class="col-md-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                <div class="feature-card p-4 bg- rounded shadow-sm h-100">
                    <div class="icon mb-3"><i class="bi bi-person-check fs-2" style="color:#bfa158;"></i></div>
                    <h5 class="mb-2">Trusted Agents</h5>
                    <p>Professional agents ready to assist you in finding your dream property.</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
                <div class="feature-card p-4 rounded shadow-sm h-100">
                    <div class="icon mb-3"><i class="bi bi-building fs-2" style="color:#bfa158;"></i></div>
                    <h5 class="mb-2">Premium Properties</h5>
                    <p>Modern and luxurious properties to fit your lifestyle and taste.</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000">
                <div class="feature-card p-4 rounded shadow-sm h-100">
                    <div class="icon mb-3"><i class="bi bi-cash-stack fs-2" style="color:#bfa158;"></i></div>
                    <h5 class="mb-2">Investment Opportunities</h5>
                    <p>Grow your wealth with our exclusive property investment options.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent Listings Section -->
<section class="recent-properties py-5" style="background:#f6f6f0;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 recent-header">
            <h3 class="recent-title">Recent Listings</h3>
            <a href="user_side/all_properties.php" class="view-more">VIEW MORE</a>
        </div>

        <div class="row">
            <?php if (!empty($properties)): ?>
                <?php foreach ($properties as $prop): ?>
                    <?php 
                        // Decrypt property details
                        $title = !empty($prop['title']) ? decrypt_data($prop['title']) : 'Property Title';
                        $propertyPage = !empty($prop['property_page']) ? decrypt_data($prop['property_page']) : 'Property';
                        $location = !empty($prop['location']) ? decrypt_data($prop['location']) : 'Unknown location';
                        $description = !empty($prop['description']) ? decrypt_data($prop['description']) : 'No description available.';

                        // Get first image
                        $first_image = 'image_7.jpg';
                        if (!empty($prop['gallery_images'])) {
                            $first_image = $prop['gallery_images'][0];
                        }
                    ?>
                    <div class="col-md-4 mb-4">
                        <a href="user_side/<?= htmlspecialchars($prop['property_page'] ?? '#') ?>.php" class="text-decoration-none text-dark">
                            <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100 d-flex flex-column">
                                
                                <!-- IMAGE -->
                                <div class="card-img-container">
                                    <img src="photo/uploads/<?= htmlspecialchars($first_image) ?>" class="card-img-top" alt="<?= htmlspecialchars($title) ?>">
                                </div>

                                <!-- BODY -->
                                <div class="card-body d-flex flex-column">
                                    <!-- Property Title -->
                                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($title) ?></h6>

                                    <!-- Property Page / Type -->
                                    <h6 class="text-muted small mb-2"><?= htmlspecialchars($propertyPage) ?></h6>

                                    <!-- Location -->
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-geo-alt-fill me-1" style="color:#bfa158;"></i>
                                        <?= htmlspecialchars($location) ?>
                                    </p>

                                    <!-- Description -->
                                    <p class="property-description small text-muted mb-2">
                                        <?= htmlspecialchars($description) ?>
                                    </p>

                                    <!-- Footer Info: Bedrooms / Bathrooms / Price -->
                                    <div class="mt-auto card-footer-info">
                                        <p class="small text-muted mb-0">
                                            <i class="bi bi-house-door-fill me-1" style="color:#bfa158;"></i> 
                                            <?= htmlspecialchars($prop['bedrooms']) ?> Bedroom &nbsp;|&nbsp; 
                                            <i class="bi bi-bucket-fill me-1" style="color:#bfa158;"></i> 
                                            <?= htmlspecialchars($prop['bathrooms']) ?> Bathroom
                                        </p>
                                        <p class="mb-1">₱<?= number_format($prop['price'], 2) ?></p>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No properties found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<!--FOOTER -->
<footer class="footer mt-0">
    <div class="container">
        <div class="row">
            <!-- About Section with Logo -->
            <div class="col-md-4 mb-4 text-center text-md-start">
                <div class="footer-logo-text mb-2">ITPH</div>
                <hr class="footer-divider">
                <p class="footer-about-text">
                    Bringing quality living closer to your future.
Iloilo Top Property Homes presents beautiful houses within well-planned subdivisions in Iloilo, providing a safe environment and modern living for homeowners
            </div>

            <!-- Quick Links -->
            <div class="col-md-2 mb-4">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="user_side/about_us.php">About Us</a></li>
                    <li><a href="user_side/news.php">Latest News</a></li>
                    <li><a href="user_side/vlogs.php">Vlogs</a></li>
                </ul>
            </div>

            <!-- Properties -->
            <div class="col-md-2 mb-4">
                <h6>Properties</h6>
                <ul class="list-unstyled">
                    <li><a href="user_side/monticello.php">Monticello</a></li>
                    <li><a href="user_side/parc_regency.php">Parc Regency</a></li>
                    <li><a href="user_side/deca_homes.php">Deca Homes</a></li>
                </ul>
            </div>

            <!-- Tools / Extras -->
            <div class="col-md-4 mb-4">
                <h6>Tools</h6>
                <ul class="list-unstyled">
                    <li><a href="user_side/contact_us.php">Contact Us</a></li>
                    <li><a href="user_side/reservation.php">Reserve Now</a></li>
                </ul>
            </div>
        </div>

        <div class="row mt-3">
    <div class="col-12 text-center">
        <a href="#top" class="back-to-top">
            <span class="arrow">➤</span> Back to Top
        </a>
    </div>
</div>

        <!-- Contact Info -->
        <div class="row mt-3">
            <div class="col-12 text-center footer-contact">
                <span><i class="bi bi-geo-alt-fill"></i> Pavia, Iloilo City</span>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <span><i class="bi bi-envelope-fill"></i> ITPH.com</span>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <span><i class="bi bi-telephone-fill"></i> (+63) 912 345 6789</span>
            </div>
        </div>

        <!-- Social Icons -->
        <div class="row mt-2">
            <div class="col-12 text-center footer-social">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-twitter"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-youtube"></i></a>
                <a href="#"><i class="bi bi-tiktok"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
                <a href="#"><i class="bi bi-pinterest"></i></a>
            </div>
        </div>

        <hr class="footer-bottom-divider">

        <!-- Bottom Footer -->
        <div class="row">
            <div class="col-12 text-center bottom-footer">
                © 2026 IloIlo Top Property Homes. All rights reserved. <a href="privacy.html">Privacy Policy</a> | <a href="terms.html">Terms and Conditions</a>
            </div>
        </div>
    </div>
</footer>



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
window.addEventListener("load", function () {
    const loader = document.getElementById("loader");

    setTimeout(() => {
        if(loader){
            loader.style.opacity = "0";
            setTimeout(() => loader.style.display = "none", 300);
        }
    }, 500);
});

setTimeout(() => {
    const loader = document.getElementById("loader");
    if(loader){
        loader.style.display = "none";
    }
}, 3000);
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