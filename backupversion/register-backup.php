<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// require_once 'db.php';
// require_once 'logout.php';
// require_once 'RegistrationProcessor.php';

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

//Original Code
// Sanitize form inputs (to prevent SQL injection)
// $user_name = mysqli_real_escape_string($conn, $_POST['userName']);
// $email = mysqli_real_escape_string($conn, $_POST['email']);
// $password = mysqli_real_escape_string($conn, $_POST['password']);
// $first_name = mysqli_real_escape_string($conn, $_POST['firstName']);
// $last_name = mysqli_real_escape_string($conn, $_POST['lastName']);

// Check if the username already exists in the database
// $check_query = "SELECT * FROM User WHERE userName = ?";
// $stmt_check = $conn->prepare($check_query);
// $stmt_check->bind_param("s", $user_name);
// $stmt_check->execute();
// $result_check = $stmt_check->get_result();

// if ($result_check->num_rows > 0) {
//     echo json_encode(['SUCCESS' => false, 'MESSAGE' => 'Username already exists. Please choose a different username.']);

//     exit();
// } else {
//     // Hash the password securely
//     $hashed_password = password_hash($password, PASSWORD_DEFAULT);

//     // Prepare and execute the SQL statement to insert user data into the User table
//     $insert_query = "INSERT INTO User (userName, firstName, lastName, email, password) VALUES (?, ?, ?, ?, ?)";
//     $stmt_insert = $conn->prepare($insert_query);
//     $stmt_insert->bind_param("sssss", $user_name, $first_name, $last_name, $email, $hashed_password);

//     if ($stmt_insert->execute()) {
//         echo json_encode(['SUCCESS' => true, 'redirect' => 'login.php']);
//         exit();
//     } else {
//         echo json_encode(['SUCCESS' => false, 'MESSAGE' => 'Registration failed: ' . $stmt_insert->error]);
//     }

//     $stmt_insert->close();

// error_log('UserName: ' . $user_name);
// error_log('Email: ' . $email);
// error_log('Password: ' . $password);

// Debudding use to be deleted. The session info will be displayed at the top of the page
if (isset($_SESSION['userID'])) {
    echo "debugging use to be deleted";
    print_r($_SESSION);
} else {
    echo "User ID is not set";
    print_r($_SESSION);
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
    <link rel="stylesheet" href="logoutStyling.css">
    <script type="text/JavaScript" src="darkmode.js" defer></script>
    <script type="text/JavaScript" src="registration.js"></script>
    <script type="text/JavaScript" src="musictoggle.js" defer></script>
    <script type="text/JavaScript" src="functionalities.js" defer></script>
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
                <div class="play"></div>
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