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
    <link rel="stylesheet" href="Style/CSS/account.css">
    <title>Account</title>
</head>
<body>
    <header id="header" class="header"></header>
    <main>
        <!-- user Section -->
        <section class="welcome">
            <h1>Username: <?php echo htmlspecialchars($user['username']); ?>!</h1>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        </section>

        <section class="account-settings">
            <h2>Update Account Information</h2>
            <?php if (isset($_GET['success'])): ?>
                <p class="success-message">Update successful!</p>
            <?php elseif (isset($_GET['error'])): ?>
                <p class="error-message"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>

            <!-- Update Email Form -->
            <form action="update_account.php" method="POST">
                <label for="new_email">New Email:</label>
                <input type="email" name="new_email" required>
                <button type="submit" name="update_email">Update Email</button>
            </form>

            <!-- Update Password Form -->
            <form action="update_account.php" method="POST">
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" required>

                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" required>

                <button type="submit" name="update_password">Update Password</button>
            </form>
        </section>
    </main>
    <footer id="footer" class="footer"></footer>
</body>
</html>
