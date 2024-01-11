<?php
require "db.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userID = htmlspecialchars($_POST['userID']);
    $selectedrole = htmlspecialchars($_POST['role']);
    $username = htmlspecialchars($_POST['username']);

    $stmt = $conn->prepare("UPDATE User SET roleID = ? WHERE userID = ?");
    $stmt->bind_param("ii", $selectedrole, $userID);
    $stmt->execute();

    if (isset($conn)) {
        $_SESSION['rolechange'] = "Role has been successfully changed!";

        //if the currently logged in user changes the role, the current session roleID will be updated too
        if  ($_SESSION['username'] =  $username){
            $_SESSION['roleID'] = $selectedrole;
        }
        header("Location: https://ictteach-www.its.utas.edu.au/groupwork/kit202-group-03/member.php");
        $conn->close();
    }
}
?>