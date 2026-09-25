<?php

session_start();

// Remove all session data
session_unset();

// Destroy the session
session_destroy();

// Return to login page
header("Location: views/login.php");
exit();

?>