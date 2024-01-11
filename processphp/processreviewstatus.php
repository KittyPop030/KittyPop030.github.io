<?php
require "db.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $commentID = htmlspecialchars($_POST['commentID']);

    $stmt = $conn->prepare("UPDATE Comment 
    SET approved = CASE WHEN approved = 1 THEN 0 ELSE 1 END WHERE commentID = ?;");

    $stmt->bind_param("i", $commentID);
    $stmt->execute();

    if (isset($conn)) {
        $_SESSION['manage'] = "Review status has been updated";
        header("Location: https://ictteach-www.its.utas.edu.au/groupwork/kit202-group-03/member.php");
        $conn->close();
    }
}
?>