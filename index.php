<?php

require_once 'logout.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'displaywelcomemessage.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Henry Croft, Matthew Laughlin, Alicia Chan">
    <title> Homepage </title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="x-icon" href="images/BrouserTabIcon.png">
    <script type="text/JavaScript" src="functionality js/overlay.js" defer></script>
    <script type="text/JavaScript" src="functionality js/darkmode.js" defer></script>
    <script type="text/JavaScript" src="functionality js/functionalities.js" defer></script>
    <script type="text/JavaScript" src="functionality js/musictoggle.js" defer></script>
    <script type="text/JavaScript" src="functionality js/showcomment.js" defer></script>
    <script type="text/JavaScript" src="functionality js/showreviewform.js" defer></script>
    

</head>

<body>
    <header>
        <div class="image-text-section">
            <img class="header-image" id="image-header" src="images/clown-fish.jpeg" alt="clown fish">
            <div class="centered-text">Homepage</div>
            <div class="welcome-text">
                <?php if (isset($_SESSION['username'])) {
                    echo $messageToDisplayToUser;
                } ?><!--display welcome message-->
            </div>
        </div>
        <img id="logo" src="images/logo.jpg" alt="site-logo">
        <nav class="navigation">
            <ul>
                <?php if (isset($_SESSION['username'])) { ?>
                    <li><a href="?logout=1" class="logout-link">Logout</a></li>
                <?php } ?>
                <?php if (isset($_SESSION['roleID']) && $_SESSION['roleID'] == 3) { ?>
                    <li><a href="member.php">Manage</a></li>
                <?php } ?>
                <?php if (isset($_SESSION['username']) && $_SESSION['roleID'] != 1) { ?>
                    <li><a href="archive.php">Post Archive</a></li>
                <?php } ?>
                <?php if (!isset($_SESSION['username'])) { ?>
                    <li><a href="register.php"> Register</a></li>
                <?php } ?>
                <?php if (!isset($_SESSION['username'])) { ?>
                    <li><a href="login.php"> Login</a></li>
                <?php } ?>
                <?php if (isset($_SESSION['roleID']) && $_SESSION['roleID'] == 3) { ?>
                    <li><a href="create.php"> Create Post</a></li>
                <?php } ?>
                <li><a href="about.php"> About</a></li>
                <li class="active"><a href="index.php" class="active"> HomePage </a></li>
            </ul>
            <ul>
                <li class="collapsible">NAV</li>
            </ul>
        </nav>
        <img src="images/moon-2.png" id="switch" alt="switch on dark or light mode">
        <div class="displayMode">DarkMode</div>
        <div class="audio_control">
            <button id="audio-button">
                <span class="play"></span>
            </button>
            <audio src="music/deepSea.mp3" id="music"></audio>
        </div>
    </header>
    <div class="success-message">
        <?php if (isset($_SESSION['success_message'])) {
            echo $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        } ?>
    </div>
    <div class="success-message">
        <?php if (isset($_SESSION['permission'])) {
            echo $_SESSION['permission'];
            unset($_SESSION['permission']);
        } ?>
    </div>
    <div class="success-message">
        <?php if (isset($_SESSION['archived'])) {
            echo $_SESSION['archived'];
            unset($_SESSION['archived']);
        } ?>
    </div>

    <div class="post-container" id="post-container">
        <?php include("displaypost.php") ?>
    </div>
    <div class="background-overlay"></div>
    <div class="overlay-window" id="overlay-container">
        <div class="overlay-window-content">
            <button id="overlay-exit-button">X</button>
            <div class="overlay-picture-section" id="overlay-picture-section">
                <!-- image inserted here -->
            </div>
            <div class="overlay-text-section" id="overlay-text-section">
                <!-- content inserted here -->
            </div>
        </div>
    </div>

    <div class="scroll" id="scrolling">
        <button type="button" class="scroll-to-top-button" id="scroll-to-top">
            <span id="arrow">></span>
        </button>
    </div>
</body>

</html>