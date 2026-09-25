<?php

session_start();

require_once "../config/database.php";
require_once "../models/user.php";

// Access control
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit();
}

$userModel = new User($conn);

// Get logged-in student's ID from session
$user_id = $_SESSION['user_id'];

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {

    $file = $_FILES['profile_picture'];

    // Check if a file was selected
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        $_SESSION['upload_error'] = "Please select a profile picture.";
        header("Location: ../views/profile.php");
        exit();
    }

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['upload_error'] = "There was an error uploading the file.";
        header("Location: ../views/profile.php");
        exit();
    }

    // Maximum file size: 2MB
    $maxSize = 2 * 1024 * 1024;

    if ($file['size'] > $maxSize) {
        $_SESSION['upload_error'] = "File size must not exceed 2MB.";
        header("Location: ../views/profile.php");
        exit();
    }

    // Get file extension
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Allowed file extensions
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    if (!in_array($extension, $allowedExtensions)) {
        $_SESSION['upload_error'] = "Only JPG, JPEG and PNG files are allowed.";
        header("Location: ../views/profile.php");
        exit();
    }

    // Create a unique filename
    $newFileName = uniqid() . '.' . $extension;

    // Upload directory
    $uploadDirectory = "../uploads/profile/";

    // Full file path
    $uploadPath = $uploadDirectory . $newFileName;

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {

        // Save filename into database
        $userModel->updateProfilePicture($user_id, $newFileName);

        $_SESSION['upload_success'] = "Profile picture uploaded successfully.";

    } else {

        $_SESSION['upload_error'] = "Failed to upload profile picture.";
    }

    header("Location: ../views/profile.php");
    exit();
}

// Retrieve only the logged-in student's profile
$user = $userModel->findById($user_id);

if (!$user) {
    session_destroy();
    header("Location: ../views/login.php");
    exit();
}

?>