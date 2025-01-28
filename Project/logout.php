<?php
// Clear the session token cookie
setcookie('session_token', '', time() - 3600, '/'); // Expire the cookie

// Redirect to the login page
header('Location: login.php');
exit;
