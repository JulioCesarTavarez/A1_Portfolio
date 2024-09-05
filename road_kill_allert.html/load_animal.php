<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $animal_type = $_POST['Animal_type'];
    $location = $_POST['Location'];
    $upload_date = date("Y-m-d H:i:s");

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["Picture"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["Picture"]["tmp_name"]);
    if($check !== false) {
        if (move_uploaded_file($_FILES["Picture"]["tmp_name"], $target_file)) {
            // Insert data into database
            $stmt = $conn->prepare("INSERT INTO animals (animal_type, location, image_path, upload_date) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $animal_type, $location, $target_file, $upload_date);
            $stmt->execute();

            echo "The file ". htmlspecialchars(basename($_FILES["Picture"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}

$conn->close();
?>