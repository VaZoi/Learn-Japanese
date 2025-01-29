<?php
ob_start(); // Start output buffering
require_once('Class/Authentication.php');

if (isset($_COOKIE['session_token'])) {
    $sessionToken = $_COOKIE['session_token'];

    // Remove session from the database
    $auth->logoutUser($sessionToken);

    // Expire the cookie
    setcookie('session_token', '', time() - 3600, '/', '', false, true);
}

// Ensure no output before redirecting
header('Location: login.php');
exit;
ob_end_flush();
