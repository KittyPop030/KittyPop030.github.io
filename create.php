<?php
require_once 'logout.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//only author can access create post
if (($_SESSION['roleID'] != 3)) {
    $_SESSION['pagename'] = 'Create';
    $_SESSION['permission'] = 'Apply to become Author to ' . $_SESSION['pagename'] . ' posts';
    header("Location: index.php");
    exit();
}

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postTitle = htmlspecialchars($_POST['postTitle']); //sanitise input
    $postTags = htmlspecialchars($_POST['postTags']); //sanitise input
    $postContent = htmlspecialchars($_POST['postContent']); //sanitise input
    $image = "";

    $sql = $conn->prepare("INSERT INTO Post (title, tag, content,userID) VALUES (?,?,?,?)");
    $sql->bind_param("sssi", $postTitle, $postTags, $postContent, $_SESSION['userID']);
    $sql->execute();
    $inserted_post_id = $conn->insert_id;

    if (isset($_FILES['fileToUpload1']['tmp_name']) && is_uploaded_file($_FILES['fileToUpload1']['tmp_name'])) {
        $stmt1 = $conn->prepare("INSERT INTO PostImage (postID, image) VALUES (?, ?)");
        $image1 = file_get_contents($_FILES['fileToUpload1']['tmp_name']);

        $stmt1->bind_param("is", $inserted_post_id, $image1);
        $stmt1->execute();
    }

    if (isset($_FILES['fileToUpload2']['tmp_name']) && is_uploaded_file($_FILES['fileToUpload2']['tmp_name'])) {
        $stmt2 = $conn->prepare("INSERT INTO PostImage (postID, image) VALUES (?, ?)");
        $image2 = file_get_contents($_FILES['fileToUpload2']['tmp_name']);

        $stmt2->bind_param("is", $inserted_post_id, $image2);
        $stmt2->execute();
    }

    if (isset($conn)) {
        $_SESSION['success_message'] = "Your Post has been successfully created!"; //store the success message in the session
        header("Location: create.php");
        $conn->close();
    } else {
        $_SESSION['success_message'] = "Opps Something went wrong!";
    }
    exit();
}
include 'displaywelcomemessage.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Henry Croft, Matthew Laughlin, Alicia Chan">
    <title> Create Post </title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="x-icon" href="images/BrouserTabIcon.png">
    <script type="text/JavaScript" src="functionality js/darkmode.js" defer></script>
    <script type="text/JavaScript" src="functionality js/functionalities.js" defer></script>
    <script type="text/JavaScript" src="validation/createpostvalidation.js" defer></script>
    <script type="text/JavaScript" src="functionality js/musictoggle.js" defer></script>
</head>

<body>
    <header>
        <div class="image-text-section">
            <img class="header-image" id="image-header" src="images/createpage2.jpg" alt="dolphins">
            <div class="centered-text">Create Post</div>
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
                    <li class="active"><a href="create.php" class="active"> Create Post</a></li>
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
        <?php if (isset($_SESSION['success_message'])) {
            echo $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        } ?>
    </div>
    <div class="containerForCreatePost"><!-- was class container -->

        <form id="createPostForm" method="POST" action="create.php" enctype="multipart/form-data" novalidate>
            <h1>Create Post</h1>
            <p>Fill out this form to create a post</p>
            <hr>
            <!-- Title field  -->
            <label for="postTitle">Title:</label>
            <input type="text" id="postTitle" name="postTitle"
                placeholder="Enter Title. Title cannot exceed 200 characters. " required>
            <div class="error-message" id="postTitleError"></div>

            <!-- Tags -->
            <label for="postTags">Tags/Keywords:</label>
            <input type="text" id="postTags" name="postTags"
                placeholder="Enter Tag. Max 3 tags allowed. Tag should be separated by commas. eg. fish,ocean,deep. Cannot exceed 50 characters.">
            <div class="error-message" id="postTagsError"></div>

            <!-- Content box -->
            <label for="postContent">Content:</label>
            <textarea type="text" id="postContent" name="postContent"
                placeholder="please enter content more than 500 characters" required></textarea>
            <div class="error-message" id="postContentError"></div>
            <br>
            <!-- new for image uplaod utilising javascript validation -->
            <label for="postImage">Select Image to uplaod (optional):</label>
            <br>
            <br>
            <input type="file" id="postImage1" name="fileToUpload1"><br>
            <button type="button" class="clear-image-btn" id="clear-image-btn1">Remove</button>
            <br>
            <br>
            <input type="file" id="postImage2" name="fileToUpload2"><br>
            <button type="button" class="clear-image-btn" id="clear-image-btn2">Remove</button>
            <br>
            <br>
            <span id="filePath"></span>
            <div class="error-message" id="postImageError"></div>
            <button type="submit" class="create-btn">Create Post</button>
            <!-- <button type="button" class="clear-image-btn">Remove Attached File</button> -->
            <button type="button" class="clear-btn">Clear</button>
        </form>
    </div>
    <div class="scroll" id="scrolling">
        <button class="scroll-to-top-button" id="scroll-to-top">
            <span id="arrow">></span>
        </button>
    </div>
</body>

</html>