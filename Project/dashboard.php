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
    <link rel="stylesheet" href="Style/CSS/dashboard.css">
    <title>Dashboard</title>
</head>
<body>
    <header id="header" class="header"></header>
    <main>
        <!-- Current Issues Section -->
        <section class="current-issues">
            <h3>Current Issues</h3>
            <ul>
                <li>Radicals can be missing or incorrect.</li>
                <li>Only one active session is allowed. Logging in on a new device will log out the previous session.</li>
            </ul>
        </section>

        <!-- Welcome Section -->
        <section class="welcome">
            <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        </section>

        <!-- Information Section -->
        <section class="info">
            <h2>About This Website</h2>
            <p>This Kanji Learn website is currently under construction.</p>
            <p>Our learning system will help you progress step by step, starting with the most common Kanji used in JLPT N5.</p>
            <p><strong>Note:</strong> The radicals displayed within some Kanji may be incorrect as the site is in progress.</p>
        </section>

        <!-- Features Section -->
        <section class="features">
            <h2>Upcoming Features</h2>
            <ul>
                <li>Interactive quizzes for Kanji and their radicals.</li>
                <li>Kanji for JLPT N4-N1.</li>
                <li>Progress tracking and achievements.</li>
            </ul>
        </section>

        <!-- Feedback Section -->
        <section class="feedback">
            <h2>We Value Your Feedback</h2>
            <p>If you encounter issues or have suggestions for improvements, please contact us at 
                <a href="mailto:zoi.vareti@gmail.com">zoi.vareti@gmail.com</a>.
            </p>
            <blockquote>
                <p>“Learning Kanji is a journey. Every step forward is a step closer to mastering the language!”</p>
            </blockquote>
            <p>Stay consistent and celebrate every small victory along the way.</p>
        </section>

        <!-- Recommended Resources Section -->
        <section class="recommend">
            <h2>Recommended Resources</h2>
            <ul>
                <li><a href="https://jisho.org" target="_blank" rel="noopener noreferrer">Jisho - Online Kanji Dictionary</a></li>
                <li><a href="https://www.tofugu.com/" target="_blank" rel="noopener noreferrer">Tofugu - Learn Japanese Blog</a></li>
                <li><a href="https://kanjialive.com" target="_blank" rel="noopener noreferrer">Kanji Alive - Learn Kanji</a></li>
                <li><a href="https://tadoku.org/japanese/en/free-books-en/" target="_blank" rel="noopener noreferrer">Tadoku - Read Kanji Books</a></li>
            </ul>
        </section>

        <section class="credit">
            <figure>
                <figcaption>Credits:</figcaption>
                <p>"SVG by Ulrich Apel (KanjiVG), used under CC BY-SA 3.0."</p>
            </figure>
        </section>
    </main>
    <footer id="footer" class="footer"></footer>
</body>
</html>
