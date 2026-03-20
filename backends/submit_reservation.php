<?php
session_start();
require_once 'config.php';

$conn = get_db_connection();

// Function to encrypt data
function encrypt($data, $key) {
    return openssl_encrypt($data, 'AES-256-CBC', $key, 0, substr($key, 0, 16));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $property = trim($_POST['property']);
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);

    // Validate phone: digits only
    if (!preg_match("/^[0-9+ ]+$/", $phone)) {
        die("Invalid phone number format.");
    }

    // Basic sanitization
    $fullname = htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $property = htmlspecialchars($property, ENT_QUOTES, 'UTF-8');
    $date = htmlspecialchars($date, ENT_QUOTES, 'UTF-8');
    $time = htmlspecialchars($time, ENT_QUOTES, 'UTF-8');

    // Encryption key
    $key = 'your-secret-key-1234567890abcdef';

    // Encrypt sensitive data
    $enc_fullname = encrypt($fullname, $key);
    $enc_email = encrypt($email, $key);
    $enc_phone = encrypt($phone, $key);

    $stmt = $conn->prepare("INSERT INTO reservations (fullname, email, phone, property, date, time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $enc_fullname, $enc_email, $enc_phone, $property, $date, $time);

    if ($stmt->execute()) {
        echo "Reservation successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}