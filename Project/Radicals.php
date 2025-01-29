<?php

require_once('Class/Authentication.php');
require_once('Class/Radicals.php');

$user = $auth->validateUserSession();
// Get the radical index from the URL (default to 0 if not provided)
$currentIndex = isset($_GET['index']) ? (int)$_GET['index'] : 0;

// Fetch radical data
$radicalData = $Radical->fetchRadicals();

// Ensure the index is within bounds
if ($currentIndex < 0 || $currentIndex >= count($radicalData)) {
    $currentIndex = 0;
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
    <link rel="stylesheet" href="Style/CSS/radical.css">
    <title>Radicals</title>
</head>
<body>
<header id="header" class="header"></header>
<p class="title">Radicals</p>
<!-- info -->
<section class="info">
    <h3>Info</h3>
    <p class="radical-block">Radical</p>
    <p class="meaning-block">Meaning</p>
</section>
<main>
    <div class="content-wrapper">
        <div class="radical-layout">
            <div class="mini-radical-buttons-container">
                <!-- Mini Radical Buttons here -->
                <div class="mini-radical-buttons">
                    <?php foreach ($radicalData as $index => $radical): ?>
                        <div class="mini-radical" onclick="goToRadical(<?php echo $index; ?>)">
                            <?php echo htmlspecialchars($radical['radical']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="radical-display-container">
                <?php if ($radicalData): ?>
                    <div class="radical-display">
                        <div id="radical-item">
                            <h1 id="radical"><?php echo htmlspecialchars($radicalData[$currentIndex]['radical']); ?></>
                            <h2 id="radical-meaning"><?php echo htmlspecialchars($radicalData[$currentIndex]['meaning']); ?></>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="navigation-buttons">
                            <button id="prev-btn" onclick="showPrevRadical()">Previous</button>
                            <button id="next-btn" onclick="showNextRadical()">Next</button>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No radicals found in the database.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="radical-index">
            <span id="radical-index"><?php echo $currentIndex + 1; ?> / <?php echo count($radicalData); ?></span>
        </div>
    </div>
</main>
<footer id="footer" class="footer"></footer>

<script>
const radicalData = <?php echo json_encode($radicalData); ?>;
let currentIndex = <?php echo $currentIndex; ?>;

// Update the Radical display
function updateRadicalDisplay() {
    const radical = radicalData[currentIndex];
    
    // Update radical and meaning
    document.getElementById('radical').innerText = radical.radical;
    document.getElementById('radical-meaning').innerText = radical.meaning;

    // Update the index display
    document.getElementById('radical-index').innerText = `${currentIndex + 1} / ${radicalData.length}`;

    // Update the URL to include the selected Radical index
    const url = new URL(window.location);
    url.searchParams.set('index', currentIndex);
    window.history.pushState({}, '', url);
}

// Navigate to the previous Radical
function showPrevRadical() {
    if (currentIndex > 0) {
        currentIndex--;
        updateRadicalDisplay();
    }
}

// Navigate to the next Radical
function showNextRadical() {
    if (currentIndex < radicalData.length - 1) {
        currentIndex++;
        updateRadicalDisplay();
    }
}

// Navigate to a specific Radical by index
function goToRadical(index) {
    currentIndex = index;
    updateRadicalDisplay();
}

// Initialize the Radical display
updateRadicalDisplay();
</script>
</body>
</html>