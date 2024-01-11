<?php
require "db.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $postID = htmlspecialchars($_POST['postID']);
    $review = trim(htmlspecialchars($_POST['review']));
    $rating = htmlspecialchars($_POST['stars']);
    $userID = htmlspecialchars($_POST['userID']);

    if (!empty($review)) {
        $sql = $conn->prepare("INSERT INTO Comment (postID, userID, description) VALUES (?, ?, ?)");
        $sql->bind_param("iis", $postID, $userID, $review);
        $sql->execute();
    }

    if (!empty($rating)) {
        $stmt = $conn->prepare("INSERT INTO Rating (scale, userID, postID) VALUES (?, ?, ?)");
        $stmt->bind_param("dii", $rating, $userID, $postID);
        $stmt->execute();
    }

    if (isset($conn)) {
        if (!empty($review)) {
            $_SESSION['success_message'] = "Congrats! You review is pending approval! ";
        }        

        header("Location: https://ictteach-www.its.utas.edu.au/groupwork/kit202-group-03/index.php");
        $conn->close();
    }
}
?>