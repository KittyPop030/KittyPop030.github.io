<?php
require "db.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $postID = htmlspecialchars($_POST['postID']);

    $stmt = $conn->prepare("UPDATE Post SET inactive = 0, archive = 0 WHERE postID = ? AND inactive = 1;");
    $stmt->bind_param("i", $postID);
    $stmt->execute();

    if (isset($conn)) {
        $_SESSION['inactivemessage'] = "Post made active!";
        header("Location: https://ictteach-www.its.utas.edu.au/groupwork/kit202-group-03/member.php");
        $conn->close();
    }
}
?>