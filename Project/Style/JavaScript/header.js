const baseurl = "/test/github/Learn-Japanese/Project";
const headerContent = `
    <header>
        <ul>
            <li><a class="h1" href="${baseurl}/dashboard.php">Learn the JLPT Kanji</a></li>
            <li><img class="Logo" src="${baseurl}/Style/Images/logo.png" alt="Logo"></li>
            <!-- Dropdown for JLPT levels -->
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">JLPT</a>
                <div class="dropdown-content">
                    <a href="${baseurl}/all-JLPT.php">All JLPT</a>
                    <a href="${baseurl}/JLPT-5.php">JLPT N5</a>
                    <a href="${baseurl}/JLPT-4.php">JLPT N4</a>
                    <a href="${baseurl}/JLPT-3.php">JLPT N3</a>
                    <a href="${baseurl}/JLPT-2.php">JLPT N2</a>
                    <a href="${baseurl}/JLPT-1.php">JLPT N1</a>
                </div>
            </li>
            <li><a href="${baseurl}/Radicals.php">Radicals</a></li>
            <li><a href="${baseurl}/JLPT-QUIZ.php">QUIZ</a></li>
            <li><a href="${baseurl}/Project/account.php">Account</a></li>
            <li><a href="${baseurl}/Project/logout.php">Logout</a></li>
        </ul>
    </header>`;

document.getElementById("header").innerHTML = headerContent;
