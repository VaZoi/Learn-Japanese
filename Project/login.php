<?php
require_once('Class/Authentication.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    $user = $auth->loginUser($usernameOrEmail, $password);
    if ($user) {
        // Generate a session token and store it
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 week'));
        $auth->createSession($user['id'], $token, $expiresAt);
        header('Location: dashboard.php'); // Redirect to a protected page
        exit;
    } else {
        $message = 'Invalid username/email or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="Style/Javascript/header.js" defer></script>
    <script src="Style/Javascript/footer.js" defer></script>
    <link rel="stylesheet" href="Style/CSS/base.css">
    <link rel="stylesheet" href="Style/CSS/login-register.css">
    <title>Login</title>
</head>
<body>
<header id="header" class="header"></header>
<main>
    <h1>Login</h1>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="username_or_email">Username or Email:</label>
        <input type="text" id="username_or_email" name="username_or_email" required><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</main>
<footer id="footer" class="footer"></footer>
</body>
</html>
