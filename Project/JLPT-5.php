<?php

require_once('Class/Authentication.php');
require_once('Class/JLPT.php');

$user = $auth->validateUserSession();

$kanjiData = $JLPT->fetchKanjiWithDetails('JLPT N5');
?>

<?php

require_once('Class/Authentication.php');
require_once('Class/JLPT.php');

$user = $auth->validateUserSession();

$kanjiData = $JLPT->fetchKanjiWithDetails('JLPT N5');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="Style/Javascript/header.js" defer></script>
    <script src="Style/Javascript/footer.js" defer></script>
    <link rel="stylesheet" href="Style/CSS/base.css">
    <link rel="stylesheet" href="Style/CSS/jlpt.css">
    <title>Dashboard</title>
</head>
<body>
<header id="header" class="header"></header>
<p class="title">JLPT N5</p>
<main>
    <div class="content-wrapper">
        <div class="kanji-layout">
            <div class="mini-kanji-buttons-container">
                <!-- Mini Kanji Buttons here -->
                <div class="mini-kanji-buttons">
                    <?php foreach ($kanjiData as $index => $kanji): ?>
                        <div class="mini-kanji" onclick="goToKanji(<?php echo $index; ?>)">
                            <?php echo htmlspecialchars($kanji['kanji']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="kanji-display-container">
                <?php if ($kanjiData): ?>
                    <div class="kanji-display">
                        <div id="kanji-item">
                            <div id="stroke-order"></div> <!-- Container for dynamic SVG -->
                            <div id="onyomi-kunyomi">
                                <div id="onyomi"></div>
                                <div id="kunyomi"></div>
                            </div>
                            <p id="kanji-meaning"><?php echo htmlspecialchars($kanjiData[0]['kanji_meaning']); ?></p>
                            <p id="radical"><?php echo htmlspecialchars($kanjiData[0]['radicals']); ?></p>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="navigation-buttons">
                            <button id="prev-btn" onclick="showPrevKanji()">Previous</button>
                            <button id="next-btn" onclick="showNextKanji()">Next</button>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No kanji found for the specified JLPT level.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="kanji-index">
            <span id="kanji-index">1 / <?php echo count($kanjiData); ?></span>
        </div>
    </div>
</main>
<footer id="footer" class="footer"></footer>

<script>
const kanjiData = <?php echo json_encode($kanjiData); ?>;
let currentIndex = 0;

function updateKanjiDisplay() {
    const kanji = kanjiData[currentIndex];
    
    document.getElementById('kanji-meaning').innerText = kanji.kanji_meaning;
    document.getElementById('radical').innerText = kanji.radicals;
    document.getElementById('onyomi').innerText = kanji.onyomi_readings;
    document.getElementById('kunyomi').innerText = kanji.kunyomi_readings;

    // Display the SVG content directly in the 'stroke-order' div
    const svgContent = kanji.stroke_order;
    const strokeOrderElement = document.getElementById('stroke-order');

    if (svgContent) {
        // Directly inject the SVG content as HTML
        strokeOrderElement.innerHTML = svgContent;
    } else {
        strokeOrderElement.innerHTML = 'No SVG available.';
    }

    // Update the index display
    document.getElementById('kanji-index').innerText = `${currentIndex + 1} / ${kanjiData.length}`;
}

// Functions to navigate between Kanji
function showPrevKanji() {
    if (currentIndex > 0) {
        currentIndex--;
        updateKanjiDisplay();
    }
}

function showNextKanji() {
    if (currentIndex < kanjiData.length - 1) {
        currentIndex++;
        updateKanjiDisplay();
    }
}

function goToKanji(index) {
    currentIndex = index;
    updateKanjiDisplay();
}

// Initialize the display with the first Kanji
updateKanjiDisplay();
</script>
</body>
</html>
