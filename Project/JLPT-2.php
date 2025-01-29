<?php

require_once('Class/Authentication.php');
require_once('Class/JLPT.php');

$user = $auth->validateUserSession();

// Get the kanji index from the URL (default to 0 if not provided)
$currentIndex = isset($_GET['index']) ? (int)$_GET['index'] : 0;

// Fetch Kanji data
$kanjiData = $JLPT->fetchKanjiWithDetails('JLPT N2');

// Ensure the index is within bounds
if ($currentIndex < 0 || $currentIndex >= count($kanjiData)) {
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
    <link rel="stylesheet" href="Style/CSS/jlpt.css">
    <title>JLPT N2 - Kanji</title>
</head>
<body>
<header id="header" class="header"></header>
<p class="title">JLPT N2</p>
<!-- info -->
<section class="info">
        <h3>Info</h3>
        <p>kanji</p>
        <ul>
            <li class="onyomi-block">Onyomi</li>
            <li class="kunyomi-block">Kunyomi</li>
        </ul>
        <p>Meaning</p>
        <p>Radicals</p>
</section>
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
                                <div id="onyomi-container">
                                    <div id="onyomi"></div>
                                </div>
                                <div id="kunyomi-container">
                                    <div id="kunyomi"></div>
                                </div>
                            </div>
                            <p id="kanji-meaning"><?php echo htmlspecialchars($kanjiData[$currentIndex]['kanji_meaning']); ?></p>
                            <p id="radical"><?php echo htmlspecialchars($kanjiData[$currentIndex]['radicals']); ?></p>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="navigation-buttons">
                            <button id="prev-btn" onclick="showPrevKanji()">Previous</button>
                            <button id="next-btn" onclick="showNextKanji()">Next</button>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="construction">No kanji found for the specified JLPT level. (Under Construction)</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="kanji-index">
            <span id="kanji-index"><?php echo $currentIndex + 1; ?> / <?php echo count($kanjiData); ?></span>
        </div>
    </div>
</main>
<footer id="footer" class="footer"></footer>

<script>
const kanjiData = <?php echo json_encode($kanjiData); ?>;
let currentIndex = <?php echo $currentIndex; ?>;

// Update the Kanji display
function updateKanjiDisplay() {
    const kanji = kanjiData[currentIndex];
    
    // Update kanji meaning and radical
    document.getElementById('kanji-meaning').innerText = kanji.kanji_meaning;
    document.getElementById('radical').innerText = kanji.radicals;

    // Clear previous onyomi and kunyomi blocks
    const onyomiContainer = document.getElementById('onyomi');
    const kunyomiContainer = document.getElementById('kunyomi');
    onyomiContainer.innerHTML = '';
    kunyomiContainer.innerHTML = '';

    // Add onyomi readings as blocks
    if (kanji.onyomi_readings) {
        kanji.onyomi_readings.split(',').forEach((reading) => {
            const block = document.createElement('div');
            block.className = 'onyomi-block';
            block.innerText = reading.trim();
            onyomiContainer.appendChild(block);
        });
    }

    // Add kunyomi readings as blocks
    if (kanji.kunyomi_readings) {
        kanji.kunyomi_readings.split(',').forEach((reading) => {
            const block = document.createElement('div');
            block.className = 'kunyomi-block';
            block.innerText = reading.trim();
            kunyomiContainer.appendChild(block);
        });
    }

    // Display the SVG content directly in the 'stroke-order' div
    const svgContent = kanji.stroke_order;
    const strokeOrderElement = document.getElementById('stroke-order');
    if (svgContent) {
        strokeOrderElement.innerHTML = svgContent;
    } else {
        strokeOrderElement.innerHTML = 'No SVG available.';
    }

    // Update the index display
    document.getElementById('kanji-index').innerText = `${currentIndex + 1} / ${kanjiData.length}`;

    // Update the URL to include the selected Kanji index
    const url = new URL(window.location);
    url.searchParams.set('index', currentIndex);
    window.history.pushState({}, '', url);
}


// Navigate to the previous Kanji
function showPrevKanji() {
    if (currentIndex > 0) {
        currentIndex--;
        updateKanjiDisplay();
    }
}

// Navigate to the next Kanji
function showNextKanji() {
    if (currentIndex < kanjiData.length - 1) {
        currentIndex++;
        updateKanjiDisplay();
    }
}

// Navigate to a specific Kanji by index
function goToKanji(index) {
    currentIndex = index;
    updateKanjiDisplay();
}

// Initialize the Kanji display
updateKanjiDisplay();
</script>
</body>
</html>
