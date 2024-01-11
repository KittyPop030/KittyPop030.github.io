<?php


$sql = "SELECT Comment.description, User.userName, Post.title, Comment.approved, 
                    Comment.creationDate,Comment.commentID,Post.archive
                    FROM Comment 
                    INNER JOIN User ON Comment.userID = User.userID 
                    INNER JOIN Post ON Comment.postID = Post.postID
                    WHERE Post.inactive = 0 
                    ORDER BY approved, title, creationDate DESC;"; //filter out inactive post, sort by specified field in descending order

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = $row["userName"];
        $review = $row["description"];
        $postitle = $row["title"];
        $approvalstatus = $row["approved"];
        $creationdate = $row["creationDate"];
        $commentID = $row["commentID"];
        $archive = $row["archive"];
        echo '                       
                        <tr>
                            <td>' . $username . '</td>
                            <td>' . $review . '</td>
                            <td>' . $postitle . '</td>
                            <td><span class="' . ($approvalstatus == 1 ? "approved" : "not-approved") . '">'
            . ($approvalstatus == 1 ? "Approved" : "Not Approved") . '</span></td>
                            <td>' . $creationdate . '</td>
                            <td>' . (($archive == 1) ? "Archive" : "HomePage") . '</td>
                            <td><form method="POST" action="processphp/processreviewstatus.php">
                            <input type="hidden" name="commentID" value="' . $commentID . '">
                            <button type="submit" class = "update-status">Update</button></form></td>
                        </tr>';
    }
}
?>