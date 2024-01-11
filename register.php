<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';
require_once 'logout.php';
require_once 'RegistrationProcessor.php';

$registrationProcessor = new RegistrationProcessor($conn); //utilise RegistrationProcessor class
// Sanitise form inputs (to prevent SQL injection)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userName = htmlspecialchars($_POST['userName']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName = htmlspecialchars($_POST['lastName']);

    $jsonresponse = $registrationProcessor->processRegistration($userName, $firstName, $lastName, $email, $password);

    if (isset($jsonresponse)) {

        if ($jsonresponse['SUCCESS']) {
            $_SESSION['user_message_successful'] = $jsonresponse['MESSAGE'];
            header('Location: login.php');
        } else {
            $_SESSION['user_message'] = $jsonresponse['MESSAGE'];
        }
        $conn->close(); // Close the database connection
    }
}

// Do not allow logged-in users to access the registration page
if (isset($_SESSION['roleID']) && ($_SESSION['roleID'] == 2 || $_SESSION['roleID'] == 3)) {
    $_SESSION['pagename'] = 'Register';
    $_SESSION['permission'] = 'Log out to access ' . $_SESSION['pagename'] . ' Page';
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Henry Croft, Matthew Laughlin, Alicia Chan">
    <title> Register </title>
    <link rel="stylesheet" href="style.css">
    <script type="text/JavaScript" src="functionality js/darkmode.js" defer></script>
    <script type="text/JavaScript" src="validation/registration.js"></script>
    <script type="text/JavaScript" src="functionality js/musictoggle.js" defer></script>
    <script type="text/JavaScript" src="functionality js/functionalities.js" defer></script>
</head>

<body>
    <header>
        <div class="image-text-section">
            <img class="header-image" src="images/register.jpg" alt="corals">
            <div class="centered-text">Register</div>
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
                    <li class="active"><a href="register.php" class="active"> Register</a></li>
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

    <div class="advertising">
        <?php
        if (isset($_SESSION['user_message'])) {
            echo $_SESSION['user_message'];
            unset($_SESSION['user_message']);
        } else {
            echo 'Become a Registered Member today to access more features!';
        }
        ?>
    </div>
    <form action="register.php" method="POST" novalidate>
        <div class="container">
            <h1>Register</h1>
            <p>Enter details to create an account</p>
            <hr>
            <label for="userName"><b>User Name</b></label>
            <input type="text" placeholder="Enter User Name" name="userName" id="userName" required>
            <div class="error-message" id="userNameError"></div>
            <label for="firstName"><b>First Name</b></label>
            <input type="text" placeholder="Enter First Name" name="firstName" id="firstName" required>

            <div class="error-message" id="firstNameError"></div>
            <label for="lastName"><b>Last Name</b></label>
            <input type="text" placeholder="Enter Last Name" name="lastName" id="lastName" required>

            <div class="error-message" id="lastNameError"></div>
            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required>

            <div class="error-message" id="emailError"></div>
            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" id="password" required>
            <!-- Changed name attribute from "password" to "password" -->
            <div class="error-message" id="passwordError"></div>
            <label for="password-repeat"><b>Confirm Password</b></label>
            <input type="password" placeholder="Confirm Password" name="password-repeat" id="password-repeat" required
                minlength="8" maxlength="32">
            <div class="error-message" id="confirmPasswordError"></div>
            <hr>
            <button type="submit" class="registerbtn">Register</button>
            <button type="button" class="clearbtn">Clear</button>
            <div class="container-error-message"></div>
            <p id="error-message">
            </p>
        </div>
    </form>
    <div class="scroll" id="scrolling">
        <button class="scroll-to-top-button" id="scroll-to-top">
            <span id="arrow">></span>
        </button>
    </div>
</body>

</html>