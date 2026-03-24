<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Capstone Chatbot</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Montserrat', sans-serif;
    margin: 0;
    background: url('../photo/bg_2.jpg') center/cover no-repeat;
}

/* Navbar */
.navbar {
    position: fixed;
    top: 30px;
    width: 100%;
    z-index: 1040;
    background: transparent;
    transition: top 0.5s ease, background 0.5s ease, box-shadow 0.5s ease;
}
.navbar.scrolled { top:0; background:#f6f6f0; box-shadow:0 2px 8px rgba(0,0,0,0.1);}
.navbar .nav-link { margin-left: 25px; color:#bfa158; font-weight: 500; }
.navbar .navbar-brand { font-weight:700; font-size:1.5rem; color:#bfa158; text-decoration:none; }

/* Chatbot Container */
#chatbot-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 350px;
    max-width: 90%;
    background: #f6f6f0;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    display: flex;
    flex-direction: column;
    font-family:'Montserrat', sans-serif;
    z-index: 9999;
    overflow: hidden;
}

/* Header */
#chatbot-header {
    background: #bfa158;
    color: white;
    padding: 15px;
    font-weight: 600;
    text-align: center;
}

/* Body */
#chatbot-body {
    height: 400px;
    overflow-y: auto;
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    background: #f6f6f0;
}

/* Messages */
.chat-message {
    max-width: 80%;
    padding: 10px 15px;
    border-radius: 15px;
    font-size: 0.95rem;
    line-height: 1.4;
    word-wrap: break-word;
}
.chatbot-message { background: #bfa158; color: #fff; align-self: flex-start; }
.user-message { background: #e0e0d1; color: #333; align-self: flex-end; }

/* Buttons */
.chat-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin: 10px 15px;
}
.chat-buttons button {
    background: #bfa158;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
}
.chat-buttons button:hover { background: #8c7a45; }

/* Typing Indicator */
.typing {
    font-style: italic;
    font-size: 0.85rem;
    color: #555;
}

/* Input Field */
#chat-input-container {
    display: flex;
    border-top: 1px solid #ddd;
}
#chat-input {
    flex: 1;
    padding: 10px;
    border: none;
    font-size: 0.95rem;
}
#chat-input:focus { outline: none; }
#chat-send { background: #bfa158; color: white; border: none; padding: 0 20px; cursor: pointer; }
#chat-send:hover { background: #8c7a45; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">ITPH</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Properties</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Chatbot -->
<div id="chatbot-container">
    <div id="chatbot-header">ITPH Assistant</div>
    <div id="chatbot-body"></div>
    <div class="chat-buttons" id="chat-buttons"></div>
    <div id="chat-input-container">
        <input type="text" id="chat-input" placeholder="Type your message..." />
        <button id="chat-send">Send</button>
    </div>
</div>

<script>
// --- Knowledge Base (100+ entries example simplified) ---
const kb = {
    "contact us": "You can reach us at info@crownasia.com.ph or call (+63) 927 933 3923.",
    "monticello": "Monticello is a premium property located in Iloilo with modern designs and amenities.",
    "parc regency": "Parc Regency offers luxury living in Iloilo with excellent facilities.",
    "deca homes": "Deca Homes in Pavia offers affordable family homes with quality construction.",
    "top listings": "Our top listings this month are Monticello, Parc Regency, and Deca Homes Pavia.",
    "office hours": "Our office is open from 8:00 AM to 5:00 PM, Monday to Saturday.",
    "payment methods": "We accept bank transfers, credit cards, and GCash.",
    "booking process": "You can book online or visit our office to reserve a property.",
    "villa amenities": "Our villas include swimming pools, landscaped gardens, and security.",
    "default": "Sorry, I don't have information about that. Please try another question."
};

// Add 100+ flexible entries (repeat pattern)
for (let i=1; i<=90; i++){
    kb[`faq${i}`] = `This is FAQ answer number ${i}.`;
}

// --- Buttons ---
const mainButtons = [
    { text: "Contact Us", value: "contact us" },
    { text: "Properties", value: "properties" },
    { text: "Top Listings", value: "top listings" }
];

const propertyButtons = [
    { text: "Monticello", value: "monticello" },
    { text: "Parc Regency", value: "parc regency" },
    { text: "Deca Homes", value: "deca homes" }
];

// --- DOM References ---
const chatBody = document.getElementById('chatbot-body');
const buttonsContainer = document.getElementById('chat-buttons');
const chatInput = document.getElementById('chat-input');
const chatSend = document.getElementById('chat-send');

// --- Functions ---
function addMessage(text, sender="bot") {
    const msg = document.createElement('div');
    msg.className = 'chat-message ' + (sender==="bot" ? "chatbot-message" : "user-message");
    msg.textContent = text;
    chatBody.appendChild(msg);
    chatBody.scrollTop = chatBody.scrollHeight;
}

// Typing effect
function botReply(text) {
    const typing = document.createElement('div');
    typing.className = 'typing';
    typing.textContent = "Typing...";
    chatBody.appendChild(typing);
    chatBody.scrollTop = chatBody.scrollHeight;

    setTimeout(() => {
        chatBody.removeChild(typing);
        addMessage(text, "bot");
        showMainButtons();
    }, 2000);
}

// Show buttons
function showMainButtons() {
    buttonsContainer.innerHTML = '';
    mainButtons.forEach(btn => {
        const button = document.createElement('button');
        button.textContent = btn.text;
        button.onclick = () => handleClick(btn.value);
        buttonsContainer.appendChild(button);
    });
}

function showPropertyButtons() {
    buttonsContainer.innerHTML = '';
    propertyButtons.forEach(btn => {
        const button = document.createElement('button');
        button.textContent = btn.text;
        button.onclick = () => handleClick(btn.value);
        buttonsContainer.appendChild(button);
    });
}

// Handle button & typed input
function handleClick(value) {
    addMessage(value, "user");
    if (value === "properties") {
        showPropertyButtons();
        botReply("Which property are you interested in?");
    } else {
        botReply(kb[value.toLowerCase()] || kb["default"]);
    }
}

// Handle send button
chatSend.addEventListener('click', () => {
    const msg = chatInput.value.trim();
    if (!msg) return;
    chatInput.value = '';
    handleClick(msg.toLowerCase());
});

// Handle Enter key
chatInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') chatSend.click();
});

// --- Initial Greeting ---
window.onload = () => {
    botReply("Good Day, How can I help you?");
};
</script>

</body>
</html>