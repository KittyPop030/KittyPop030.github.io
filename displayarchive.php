<?php
require "db.php";

$sql = "SELECT Post.*, User.userName
        FROM Post
        INNER JOIN User ON User.userID = Post.userID
        LEFT JOIN PostImage ON PostImage.postID = Post.postID
        WHERE Post.archive = 1 and Post.inactive <> 1
        GROUP BY Post.postID
        ORDER BY publishedDate DESC;"; //sorted in descending order    

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $postID = $row["postID"];
        $images = []; //to store the result of images found
        $image_query = "SELECT image FROM PostImage WHERE postID = $postID";
        $comment_query = "SELECT Comment.description, User.userName,Comment.creationDate 
                          FROM Comment 
                          INNER JOIN User ON Comment.userID = User.userID 
                          WHERE Comment.postID = $postID and approved <> 0
                          ORDER BY creationDate DESC "; //only approved comments are allowed to be displayed
        $rating_query = "SELECT AVG(scale) as avg_rating, COUNT(scale) as num_ratings FROM Rating WHERE postID = $postID ";
        
        $image_Result = $conn->query($image_query);
        $comment_result = $conn->query($comment_query);
        $rating_result = $conn->query($rating_query);

        //image retrieval reference https://stackoverflow.com/questions/10850605/display-image-from-sql
        if ($image_Result && $image_Result->num_rows > 0) {
            while ($image_table_row = $image_Result->fetch_assoc()) {
                $images[] = base64_encode($image_table_row["image"]);
            }
        }

        if ($rating_result && $rating_result->num_rows > 0) {
            $rating_row = $rating_result->fetch_assoc();
            $avg_rating = round($rating_row['avg_rating'], 1);
        }

        $fullStar = floor($avg_rating); //determine how many full stars to print
        $halfStar = ($avg_rating - $fullStar) >= 0.5 ? 1 : 0; //determine how many half stars to print       
        $fullstarpath = '<img src=images/fullstarrating.png>';
        $halfstarpath = '<img src=images/halfstarrating.png>';
        $ratingtoprint = '';
        $ratingtoprint = str_repeat($fullstarpath, $fullStar) . str_repeat($halfstarpath, $halfStar); //concat  

        echo '<div class="post-box-archive">
                <div class="archive-post-text">
                    <div class="archive-description">
                        <div class="archive-title">
                        <h1 class="title">' . html_entity_decode($row["title"]) . '</h1>
                        </div>
                    <div class=author-and-date>
                        <label class="date">' . date("d.m.Y", strtotime($row["publishedDate"])) . ' </label>
                        <label>|</label>
                        <label class="author">Author: ' . html_entity_decode($row["userName"]) . '</label>';

        $unarchiveform = '&nbsp<form id="unarchive-form" method="POST" action = "processphp/processunarchive.php">
                        <input type="hidden" name = "postID" value="' . $postID . '">
                        <input type="hidden" name = "status" value="0">
                        <button type="submit" class="archive-post-button">Make active</button></form>';

        $inactiveform = '&nbsp&nbsp<form id="inactive-form" method="POST" action = "processphp/processinactive.php">
                        <input type="hidden" name = "postID" value="' . $postID . '">
                        <input type="hidden" name = "status" value="1">
                        <button  type="submit" class="archive-post-button">Make Inactive</button></form>';

        if (!empty($ratingtoprint)) {
            echo '<label class="spacing">|</label>
                                <label class="rating">Rating: ' . $ratingtoprint . '</label>';
            echo '<label class="count">&nbsp reviewed by  ' . $rating_row["num_ratings"] . ' '
                . ($rating_row["num_ratings"] == 1 ? 'adventurer' : 'adventurers') . '</label> ';
        } else {
            echo '<label class="spacing">|</label>
                    <label class="rating">Rating: None</label>';
        }

        echo '</div>                    
                <div class="archive-post-label">';

        $tags = explode(',', $row["tag"]); //split the tags into an array              
        //print out each tag
        foreach ($tags as $tag) {
            echo '<label>#' . html_entity_decode(trim($tag)) . '</label>'; // trim white space
        }

        if ($_SESSION['roleID'] == 3) {
            echo $unarchiveform;
            echo $inactiveform;
        }

        $comments = '';
        if ($comment_result && $comment_result->num_rows > 0) {
            while ($comment_table_row = $comment_result->fetch_assoc()) {
                $comments .= '<h2 class = "commenter">Member: ' . html_entity_decode($comment_table_row["userName"])
                    . ',  Date: ' . date("d.m.Y", strtotime($comment_table_row["creationDate"])) .
                    ' says </h2><br>' . '<div class="comment-text">' . html_entity_decode($comment_table_row["description"]) . '</div>' . '<br>';
            }
        }

        echo '</div>
                 </div>                    
                    <button id="archive-button" class="accordion">Read More</button>                    
                    <div class="archive-reveal-section-container">
                        <div class="archive-image">';
        if ($images != NULL) {
            echo '<img src="data:image/jpeg;base64,' . $images[0] . '" alt="archive-image" class="archive-image-img post-image-itself" 
            data-image2 = "' . (isset($images[1]) ? $images[1] : $images[0]) . '">';
        } else {
            echo '<img src="images/to-be-revealed.jpg" alt="archive-image" class="archive-image-img post-image-itself" >';
        }
        echo '</div>             
                 <div class="archive-main-content">
                 <div>' . html_entity_decode($row["content"]) . '</div><br><hr>
                 <div class="archived-comment-heading">Archived Comments:</div>
                 <div class="archived-comment">' . (!empty($comments) ? $comments : 'No comments available!') . '</div>              
                 </div>               
            </div>
        </div>
        </div>';
    }
}

if (isset($conn)) {
    $conn->close();
}
?>