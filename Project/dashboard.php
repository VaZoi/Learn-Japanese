<?php

require_once('Class/Authentication.php');

$user = $auth->validateUserSession();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="Style/Javascript/header.js" defer></script>
    <script src="Style/Javascript/footer.js" defer></script>
    <link rel="stylesheet" href="Style/CSS/base.css">
    <title>Dashboard</title>
</head>
<body>
<header id="header" class="header"></header>
    <main>
        <div class="welcome">
            <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        </div>
    </main>
<footer id="footer" class="footer"></footer>
</body>
</html>
