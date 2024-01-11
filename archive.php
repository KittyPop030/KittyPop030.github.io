<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'logout.php';
$message = '';

/** Checking if user is not logged or has the roleID of 1 (visitor) */
include 'displaywelcomemessage.php';

if ((!isset($_SESSION['roleID']) || $_SESSION['roleID'] == '1')) {
    $_SESSION['pagename'] = 'Archive';
    $_SESSION['permission'] = 'Become a member to access ' . $_SESSION['pagename'];
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Henry Croft, Matthew Laughlin, Alicia Chan">
    <title> Archive </title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="x-icon" href="images/BrouserTabIcon.png">
    <script type="text/JavaScript" src="functionality js/darkmode.js" defer></script>
    <script type="text/JavaScript" src="functionality js/functionalities.js" defer></script>
    <script type="text/JavaScript" src="functionality js/archivecollapse.js" defer></script>
    <script type="text/JavaScript" src="functionality js/musictoggle.js" defer></script>
    <script type="text/JavaScript" src="functionality js/post-photo-switch.js" defer></script>
    <script type="text/JavaScript" src="functionality js/archiveimage.js" defer></script>
</head>

<body>
    <header>
        <div class="image-text-section">
            <img class="header-image" id="image-header" src="images/archive.jpg" alt="sea turtle">
            <div class="centered-text">Archive</div>
            <div class="welcome-text">
                <?php if (isset($_SESSION['username'])) {
                    echo $messageToDisplayToUser;
                    echo $message;
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
                    <li class="active"><a href="archive.php" class="active">Post Archive</a></li>
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
                <li><a href="index.php"> HomePage </a></li>
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
        <?php if (isset($_SESSION['inactivemessage'])) {
            echo $_SESSION['inactivemessage'];
            unset($_SESSION['inactivemessage']);
        } ?>
        <?php if (isset($_SESSION['inactivemessage'])) {
            echo $_SESSION['inactivemessage'];
            unset($_SESSION['inactivemessage']);
        } ?>
        <?php if (isset($_SESSION['unarchive'])) {
            echo $_SESSION['unarchive'];
            unset($_SESSION['unarchive']);
        } ?>

    </div>
    <div class="post-container" id="post-container">
        <?php include("displayarchive.php") ?>
        <div class="scroll" id="scrolling">
            <button class="scroll-to-top-button" id="scroll-to-top">
                <span id="arrow">></span>
            </button>
        </div>
    </div>
</body>

</html>