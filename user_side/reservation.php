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
<title>Property Reservation</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/common.css">
<link rel="stylesheet" href="css/reservation.css">
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

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="index.php">ITPH</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav me-3">
        <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about_us.php">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="all_properties.php"> Properties</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Explore</a></li>
        <li class="nav-item dropdown position-static">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">News & Blogs</a>
          <div class="dropdown-menu w-100 p-4">
            <div class="row">
              <div class="col-md-6">
                <h6 class="fw-bold"><i class="bi bi-newspaper"></i> Latest News</h6>
                <p class="small text-muted">Stay updated with the latest real estate updates and subdivision announcements.</p>
                <a href="news.php" class="btn btn-outline-primary btn-sm">View News</a>
              </div>
              <div class="col-md-6">
                <h6 class="fw-bold"><i class="bi bi-camera-video"></i> Vlogs</h6>
                <p class="small text-muted">Watch our latest property tours, real estate tips, and guides about buying homes and investing in property.</p>
                <a href="vlogs.php" class="btn btn-outline-primary btn-sm">Watch Vlogs</a>
              </div>
            </div>
          </div>
        </li>
        
      </ul>
      <a href="contact_us.php" class="btn btn-reserve">Reach Us</a>
    </div>
  </div>
</nav>

<!--CHAT BOT-->
<div id="chat-bubble" onclick="toggleChat()"><i class="bi bi-chat-dots-fill"></i></div>
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


<!-- Reservation Form -->
<div class="reservation-bg position-relative">
    <div class="rsv-overlay"></div>

    <div class="container position-relative" style="z-index:3;">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card card-reservation p-5">
                    <h3 class="mb-4 text-center">Reservation Form</h3>
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
                            <input type="text" class="form-control bg-light" name="property_page"
                                value="<?php echo htmlspecialchars($house . ' - ' . $property); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Preferred Date</label>
                            <input type="date" class="form-control" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Preferred Time</label>
                            <input type="time" class="form-control" name="time" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                            <label class="form-check-label" for="agreeTerms">
                                I agree to the 
                                <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a> 
                                and 
                                <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a>
                            </label>
                        </div>

                        <!-- Back & Confirm Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" onclick="history.back()">CANCEL</button>
                            <button type="submit" class="btn btn-primary">CONFIRM</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Here you can write your full Terms and Conditions content...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Privacy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Here you can write your full Privacy Policy content...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- About Section with Logo -->
            <div class="col-md-4 mb-4 text-center text-md-start">
                <div class="footer-logo-text mb-2">ITPH</div>
                <hr class="footer-divider">
                <p class="footer-about-text">
                    Bringing quality living closer to your future.
                    Iloilo Top Property Homes presents beautiful houses within well-planned subdivisions in Iloilo, providing a safe environment and modern living for homeowners
                </p>
            </div>
            <!-- Quick Links -->
            <div class="col-md-2 mb-4">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../user_side/about_us.php">About Us</a></li>
                    <li><a href="../user_side/news.php">Latest News</a></li>
                    <li><a href="../user_side/vlogs.php">Vlogs</a></li>
                </ul>
            </div>

            <!-- Properties -->
            <div class="col-md-2 mb-4">
                <h6>Properties</h6>
                <ul class="list-unstyled">
                    <li><a href="../user_side/monticello.php">Monticello</a></li>
                    <li><a href="../user_side/parc_regency.php">Parc Regency</a></li>
                    <li><a href="../user_side/deca_homes.php">Deca Homes</a></li>
                </ul>
            </div>

            <!-- Tools / Extras -->
            <div class="col-md-4 mb-4">
                <h6>Tools</h6>
                <ul class="list-unstyled">
                    <li><a href="../user_side/contact_us.php">Contact Us</a></li>
                    <li><a href="">Reserve Now</a></li>
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
                <span><i class="bi bi-geo-alt-fill"></i> The HQ, 3/F Vista Hub at SOMO, Daang Hari Road, Bacoor City, Cavite</span>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <span><i class="bi bi-envelope-fill"></i> info@serbisyos.com</span>
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
                © 2026 IloIlo Top Property Homes. All rights reserved. 
                <a href="privacy.html">Privacy Policy</a> | 
                <a href="terms.html">Terms and Conditions</a>
            </div>
        </div>
    </div>
</footer>
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