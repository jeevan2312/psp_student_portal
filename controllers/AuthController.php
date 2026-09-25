<?php

// Show PHP errors during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once "../config/database.php";
require_once "../models/user.php";

$userModel = new User($conn);


/* =========================================
   LOGIN
   ========================================= */

if (isset($_POST['login'])) {

    $nric = trim($_POST['nric'] ?? '');
    $password = $_POST['password'] ?? '';

    // Server-side validation
    if (empty($nric) || empty($password)) {

        $_SESSION['error'] = "Please enter NRIC and password.";

        header("Location: ../views/login.php");
        exit();
    }

    // Find user by NRIC
    $user = $userModel->findByNRIC($nric);

    // Verify hashed password
    if ($user && password_verify($password, $user['password'])) {

        // Prevent session fixation
        session_regenerate_id(true);

        // Store logged-in student's ID
        $_SESSION['user_id'] = $user['id'];

        header("Location: ../views/profile.php");
        exit();

    } else {

        $_SESSION['error'] = "Invalid NRIC or password.";

        header("Location: ../views/login.php");
        exit();
    }
}


/* =========================================
   CHANGE PASSWORD
   ========================================= */

elseif (isset($_POST['change_password'])) {

    // User must be logged in
    if (!isset($_SESSION['user_id'])) {

        header("Location: ../views/login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';


    // Check empty fields
    if (
        empty($old_password) ||
        empty($new_password) ||
        empty($confirm_password)
    ) {

        $_SESSION['error'] = "Please fill in all password fields.";

        header("Location: ../views/change_password.php");
        exit();
    }


    // Minimum password length
    if (strlen($new_password) < 6) {

        $_SESSION['error'] =
            "New password must contain at least 6 characters.";

        header("Location: ../views/change_password.php");
        exit();
    }


    // Check new password and confirmation
    if ($new_password !== $confirm_password) {

        $_SESSION['error'] =
            "New password and confirm password do not match.";

        header("Location: ../views/change_password.php");
        exit();
    }


    // Retrieve logged-in user including password
    $user = $userModel->findByIdWithPassword($user_id);

    if (!$user) {

        session_destroy();

        header("Location: ../views/login.php");
        exit();
    }


    // Verify OLD password
    if (!password_verify($old_password, $user['password'])) {

        $_SESSION['error'] = "Old password is incorrect.";

        header("Location: ../views/change_password.php");
        exit();
    }


    // Prevent using the same password again
    if (password_verify($new_password, $user['password'])) {

        $_SESSION['error'] =
            "New password cannot be the same as the old password.";

        header("Location: ../views/change_password.php");
        exit();
    }


    // Hash NEW password
    $hashedPassword = password_hash(
        $new_password,
        PASSWORD_DEFAULT
    );


    // Update password using Model
    if ($userModel->updatePassword($user_id, $hashedPassword)) {

        $_SESSION['success'] =
            "Password changed successfully.";

        header("Location: ../views/change_password.php");
        exit();

    } else {

        $_SESSION['error'] =
            "Failed to update password. Please try again.";

        header("Location: ../views/change_password.php");
        exit();
    }
}


/* =========================================
   DIRECT ACCESS
   ========================================= */

else {

    header("Location: ../views/login.php");
    exit();
}

?>