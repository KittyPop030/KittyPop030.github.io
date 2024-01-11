<?php
require "db.php";
require_once 'logout.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['username']) && $_SESSION['roleID'] == 1 || !isset($_SESSION['username'])) {
    $_SESSION['pagename'] = 'Manage';
    $_SESSION['permission'] = 'You cannot access ' . $_SESSION['pagename'] . ' Page';
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['username']) && $_SESSION['roleID'] == 2 || !isset($_SESSION['username'])) {
    $_SESSION['pagename'] = 'Manage';
    $_SESSION['permission'] = 'You cannot access ' . $_SESSION['pagename'] . ' Page';
    header("Location: index.php");
    exit();
}

include 'displaywelcomemessage.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Henry Croft, Matthew Laughlin, Alicia Chan">
    <title> Manage Role </title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="x-icon" href="images/BrouserTabIcon.png">
    <script type="text/JavaScript" src="functionality js/darkmode.js" defer></script>
    <script type="text/JavaScript" src="functionality js/functionalities.js" defer></script>
    <script type="text/JavaScript" src="functionality js/musictoggle.js" defer></script>
    <script type="text/JavaScript" src="functionality js/managecollapse.js" defer></script>

<body>
    <header>
        <div class="image-text-section">
            <img class="header-image" id="image-header" src="images/bluewhale.jpg" alt="bluewhale">
            <div class="centered-text">Site Manager</div>
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
                    <li class="active"><a href="member.php" class="active">Manage</a></li>
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
        <?php if (isset($_SESSION['manage'])) {
            echo $_SESSION['manage'];
            unset($_SESSION['manage']);
        } ?>
        <?php if (isset($_SESSION['archivemessage'])) {
            echo $_SESSION['archivemessage'];
            unset($_SESSION['archivemessage']);
        } ?>
        <?php if (isset($_SESSION['inactivemessage'])) {
            echo $_SESSION['inactivemessage'];
            unset($_SESSION['inactivemessage']);
        } ?>
        <?php if (isset($_SESSION['rolechange'])) {
            echo $_SESSION['rolechange'];
            unset($_SESSION['rolechange']);
        } ?>
    </div>
    <div class="container mgm-container">
        <button class="mgm-menu accordion3">Review Approval</button>
        <div class="mgm-item mgm-item-option1">
            <div class="item-content item-content-option1">
                <table class=roletable>
                    <tr class=rolerow>
                        <th>UserName</th>
                        <th>Review</th>
                        <th>Post Title</th>
                        <th>Approval Status</th>
                        <th>Creation Date</th>
                        <th>Location</th>
                        <th>Update Status</th>
                    </tr>
                    <?php include("manager/reviewapproval.php"); ?>
                </table>
            </div>
        </div>
        <button class="mgm-menu accordion3">Manage User Role</button>
        <div class="mgm-item">
            <div class="item-content">
                <table class=roletable>
                    <tr class=rolerow>
                        <th>UserName</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Current Role</th>
                        <th>Update</th>
                    </tr>
                    <?php include("manager/manageuserrole.php"); ?>
                </table>
            </div>
        </div>
        <button class="mgm-menu accordion3">View Active Post</button>
        <div class="mgm-item mgm-item3">
            <div class="item-content">
                <?php include("manager/viewactivepost.php"); ?>
            </div>
        </div>
        <button class="mgm-menu accordion3">Manage Inactive Post</button>
        <div class="mgm-item">
            <div class="item-content">
                <?php include("manager/manageinactivepost.php"); ?>
            </div>
        </div>
    </div>
    <div class="scroll" id="scrolling">
        <button class="scroll-to-top-button" id="scroll-to-top">
            <span id="arrow">></span>
        </button>
    </div>
</body>

</html>