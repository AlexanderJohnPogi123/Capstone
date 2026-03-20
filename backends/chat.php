<?php
// backends/chat.php
require_once 'config.php';
$conn = get_db_connection();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = $_POST['message'] ?? '';

    if (empty($userInput)) {
        echo json_encode(['reply' => 'Please type a message.']);
        exit;
    }

    // --- YOUR CUSTOM KNOWLEDGE BASE & RULES ---
    $systemInstruction = "
    Role: Professional Customer Support for 'Iloilo Top Property Homes'.
    
    KNOWLEDGE BASE:
    - Company: Iloilo Top Property Homes.
    - Locations: Iloilo City, Pavia, Jaro, Mandurriao.
    - Property 1: 'Monticello' (Montimo) - Located in Pavia. 3 Bedrooms, 2 Bathrooms.
    - Property 2: 'Parc Regency' - Located in Pavia. High-end amenities, flood-free.
    - Property 3: 'Deca Homes Pavia' - Affordable housing, 2 Bedrooms.
    - Property 4: '2 Bedroom Condo' - Located in MegaWorld, Mandurriao.
    - Contact: Cell: 1234567890, Tel: 123445, Email: asdqwe@gmail.com.

    RULES:
    1. ONLY answer using the info above. 
    2. If info is NOT found, say: 'I’m sorry, but I don’t have that information. Please contact us at 1234567890.'
    3. Do not provide legal/financial advice.
    4. Stay polite and professional.
    ";

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $api_key;
    
    $payload = [
        "system_instruction" => ["parts" => [["text" => $systemInstruction]]],
        "contents" => [["role" => "user", "parts" => [["text" => $userInput]]]]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 

    $response = curl_exec($ch);
    $responseData = json_decode($response, true);
    curl_close($ch);

    $botReply = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? "I am currently offline. Please try again later.";

    // Save to Database (for your analytics/capstone requirement)
    $stmt = $conn->prepare("INSERT INTO chat_logs (user_message, bot_response) VALUES (?, ?)");
    $stmt->bind_param("ss", $userInput, $botReply);
    $stmt->execute();

    echo json_encode(['reply' => $botReply]);
}