let currentIndex = 0;

async function updateKanjiDisplay() {
    const kanji = kanjiData[currentIndex];
    if (!kanji) return; // Exit if no kanji available

    document.getElementById('kanji').innerText = kanji.kanji;
    document.getElementById('kanji-meaning').innerText = kanji.kanji_meaning;
    document.getElementById('radical').innerText = kanji.radicals;
    document.getElementById('onyomi').innerText = kanji.onyomi_readings;
    document.getElementById('kunyomi').innerText = kanji.kunyomi_readings;

    const stroke_order = kanji.stroke_order;
    let svgContent = 'No SVG available.';

    // Validate the URL and fetch the SVG if it's a URL
    if (stroke_order && isValidUrl(stroke_order)) {
        try {
            const svgElement = await getSvgFromUrl(stroke_order);
            if (svgElement) {
                svgElement.setAttribute('width', '30%');
                svgElement.setAttribute('height', 'auto');
                svgContent = svgElement.outerHTML;
            }
        } catch (error) {
            console.error('Error fetching or parsing SVG:', error);
            svgContent = 'Error loading SVG.';
        }
    }

    document.getElementById('stroke-order').innerHTML = svgContent;
}

// Validate URL format
function isValidUrl(url) {
    try {
        new URL(url);
        return true;
    } catch (e) {
        return false;
    }
}

// Fetch the SVG from the given URL
async function getSvgFromUrl(url) {
    const response = await fetch(url);
    const htmlContent = await response.text();
    const dom = new DOMParser().parseFromString(htmlContent, 'text/html');
    return dom.querySelector('svg');
}

// Show the previous Kanji
function showPrevKanji() {
    if (currentIndex > 0) {
        currentIndex--;
        updateKanjiDisplay();
    }
}

// Show the next Kanji
function showNextKanji() {
    if (currentIndex < kanjiData.length - 1) {
        currentIndex++;
        updateKanjiDisplay();
    }
}

// Initialize the display with the first Kanji
document.addEventListener('DOMContentLoaded', () => {
    if (kanjiData.length > 0) {
        updateKanjiDisplay();
    } else {
        document.getElementById('kanji-display').innerText = 'No Kanji available.';
    }
});
