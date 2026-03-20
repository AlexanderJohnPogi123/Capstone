<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn = get_db_connection();

    // TEXT FIELDS
    $property_page = sanitize_input($_POST['property_page']);
    $title = encrypt_data(sanitize_input($_POST['title']));
    $location = encrypt_data(sanitize_input($_POST['location']));
    $description = encrypt_data(sanitize_input($_POST['description']));

    // NUMERIC
    $price = floatval($_POST['price']);
    $bedrooms = intval($_POST['bedrooms']);
    $bathrooms = intval($_POST['bathrooms']);

    // INSERT PROPERTY FIRST (without image)
 $stmt = $conn->prepare("INSERT INTO propertiies 
(title, price, location, bedrooms, bathrooms, description, property_page) 
VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "sdsiiss",
        $title,
        $price,
        $location,
        $bedrooms,
        $bathrooms,
        $description,
        $property_page
    );

    if (!$stmt->execute()) {
        die("Error: " . $stmt->error);
    }

    // GET INSERTED PROPERTY ID
    $property_id = $stmt->insert_id;

    // HANDLE MULTIPLE IMAGES
    $targetDir = __DIR__ . '/../photo/uploads/';
    $allowedTypes = ['jpg','jpeg','png','gif'];

    foreach ($_FILES['images']['name'] as $key => $name) {

        if ($_FILES['images']['error'][$key] === 0) {

            $tmp = $_FILES['images']['tmp_name'][$key];

            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedTypes)) {
                continue; // skip invalid files
            }

            $newName = time() . "_" . $name;
            $targetFile = $targetDir . $newName;

            if (move_uploaded_file($tmp, $targetFile)) {

                $encryptedImage = encrypt_data($newName);

                $imgStmt = $conn->prepare("INSERT INTO property_images (property_id, image) VALUES (?, ?)");
                $imgStmt->bind_param("is", $property_id, $encryptedImage);
                $imgStmt->execute();
            }
        }
    }

    header("Location: ../admin_side/index.php?success=property_added");
    exit();
}
?>