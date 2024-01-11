<?php require "db.php";

if (isset($_GET['imageID'])) {
    $imageID = $_GET['imageID'];

    $sql = "SELECT image FROM Image WHERE imageID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $imageID);

    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($image);
        $stmt->fetch();

        header("Content-type: image/png");
        echo $image;
    }
}
?>