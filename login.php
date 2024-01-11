<?php
//THIS IS FIXED I THINK, JS VALIDATION APPLIED

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


//do not allow logged in user accessing login page
if (isset($_SESSION['roleID']) && ($_SESSION['roleID'] == 2 || $_SESSION['roleID'] == 3)) {
    $_SESSION['pagename'] = 'Log in';
    $_SESSION['permission'] = 'Log out to ' . $_SESSION['pagename'] . ' to another account';
    header("Location: index.php");
    exit();
}

//database connection
require_once 'db.php';
require_once 'logout.php';


$errorMessage = ''; //variable to store error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = htmlspecialchars($_POST['uname']);
    $inputPassword = htmlspecialchars($_POST['psw']);

    //ADDED TO PREVENT entering empty credentials
    if (empty($uname) || empty($inputPassword)) {
        // $_SESSION['error_message'] = 'Please fill in both fields';
        header("Location: login.php");
        exit();
    }

    //Retrieve the hashed password from the database
    //slightly modified by using prepare statement for more securtiy
    $query = $conn->prepare("SELECT password FROM User WHERE userName = ?");
    $query->bind_param("s", $uname);
    $query->execute();
    // $query = "SELECT password FROM User WHERE userName = '$uname'";  original line of code
    $result = $query->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the entered password against the hashed password
        if (password_verify($inputPassword, $hashed_password)) {
            // Passwords match, user is authenticated
            $_SESSION['username'] = $uname;
            //Retrieving their roleID to determing access to pages
            //userID are unique identifiers specific to users, different from roleID
            $query = $conn->prepare("SELECT roleID, userID FROM User WHERE userName = ?");
            $query->bind_param("s", $uname);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $_SESSION['roleID'] = $row['roleID'];
                $_SESSION['userID'] = $row['userID']; //added
            }
            header("Location: index.php");
            exit();
        } else {
            // Passwords do not match
            $_SESSION['error_message'] = 'Incorrect password. Please try again.'; //moved the echo error output to the html body
        }
    } else {
        // User not found in the database
        $_SESSION['error_message'] = 'User not found. Please try again.'; //moved the echo error output to the html body
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Henry Croft, Matthew Laughlin, Alicia Chan">
    <title> Login </title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="x-icon" href="images/BrouserTabIcon.png">
    <script type="text/JavaScript" src="functionality js/script.js" defer></script>
    <script type="text/JavaScript" src="functionality js/darkmode.js" defer></script>
    <script type="text/JavaScript" src="functionalities.js" defer></script>
    <script type="text/JavaScript" src="functionality js/musictoggle.js" defer></script>
    <script type="text/JavaScript" src="functionality js/errormessageposition.js" defer></script>
    <script type="text/JavaScript" src="validation/LoginInputValidation.js" defer></script>
</head>

<body>
    <header>
        <div class="image-text-section">
            <img class="header-image" id="image-header" src="images/login.jpg" alt="marine animal">
            <div class="centered-text">Login</div>
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
                    <li class="active"><a href="login.php" class="active"> Login</a></li>
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

        </div>
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
        if (isset($_SESSION['user_message_successful'])) {
            echo $_SESSION['user_message_successful'];
            unset($_SESSION['user_message_successful']);
        }
        ?>
    </div>
    <form id="loginForm" action=<?= !empty($errorMessage) ? "login.php#error-message-position" : "login.php" ?>
        method="POST" novalidate>
        <div class="container">
            <h1>Login</h1>
            <p>Enter details to log in</p>
            <hr>
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname" id="uname" required>
            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
            <hr>
            <button type="submit" id="login-submit-button">Login</button>
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
            <a name="error-message-position"></a>
            <!-- attach ancher so the the page will be scrolled to this section if error occurs -->
            <div class="error-message-login" id="error-message-display">
                <?php
                if (isset($_SESSION['error_message'])) {
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                }
                ?>
            </div>
            <div>
                <button type="button" class="cancelbtn" id="cancelbutton">Cancel</button>
                <span class="psw"> <a href="register.php" id="forget-password">Forgot password?</a></span>
            </div>
            <p id="register-link"><a href="register.php" id="not-member">Not a member yet? Register</a></p>
            <!-- Register link -->
        </div>
        <div class="scroll" id="scrolling">
            <button class="scroll-to-top-button" id="scroll-to-top">
                <span id="arrow">></span>
            </button>
        </div>
    </form>
</body>

</html>