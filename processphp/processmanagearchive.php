<?php
require "db.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $postID = htmlspecialchars($_POST['postID']);

    $stmt = $conn->prepare("UPDATE Post SET archive = 1, inactive = 0  WHERE postID = ? AND archive = 0;");
    $stmt->bind_param("i", $postID);
    $stmt->execute();

    if (isset($conn)) {
        $_SESSION['archivemessage'] = "Post Archived!";
        header("Location: https://ictteach-www.its.utas.edu.au/groupwork/kit202-group-03/member.php");
        $conn->close();
    }
}
?>