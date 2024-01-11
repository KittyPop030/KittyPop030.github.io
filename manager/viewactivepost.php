<?php
//https://stackoverflow.com/questions/3109978/display-numbers-with-ordinal-suffix-in-php 
//guided solution
function ordinalSuffix( $n )
{
  return date('S',mktime(1,1,1,1,( (($n>=10)+($n>=20)+($n==0))*10 + $n%10) ));
}

$sql = "SELECT Post.*, User.userName
        FROM Post
        INNER JOIN User ON User.userID = Post.userID
        LEFT JOIN PostImage ON PostImage.postID = Post.postID
        WHERE Post.archive <> 1 and Post.inactive <> 1
        GROUP BY Post.postID
        ORDER BY publishedDate DESC;"; //sorted in descending order so it fetches the most recent 4 posts. Archive and inactive status cannot be true.   

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $counter = 0; //initialise counter for displaying Live for first page
    $counter2 = 1;

    while ($row = $result->fetch_assoc()) {

        $postID = $row["postID"];
        $images = []; //to store the result of images found    

        $comment_query = "SELECT Comment.description, User.userName,Comment.creationDate 
                          FROM Comment 
                          INNER JOIN User ON Comment.userID = User.userID 
                          WHERE Comment.postID = $postID and approved <> 0
                          ORDER BY creationDate DESC "; //only approved comments are allowed to be displayed
        $rating_query = "SELECT AVG(scale) as avg_rating, COUNT(scale) as num_ratings FROM Rating WHERE postID = $postID "; //get the average rating and the number of ratings
        $image_query = "SELECT image FROM PostImage WHERE postID = $postID";

        $image_result = $conn->query($image_query); //result querying Comment table
        $rating_result = $conn->query($rating_query); //average rating and the number of ratings
        $comment_result = $conn->query($comment_query);

        if ($rating_result && $rating_result->num_rows > 0) {
            $rating_row = $rating_result->fetch_assoc();
            $avg_rating = round($rating_row['avg_rating'], 1);
        }

        if ($image_result && $image_result->num_rows > 0) {
            while ($image_table_row = $image_result->fetch_assoc()) {
                $images[] = base64_encode($image_table_row["image"]);
            }
        }

        $fullStar = floor($avg_rating); //determine how many full stars to print
        $halfStar = ($avg_rating - $fullStar) >= 0.5 ? 1 : 0; //determine how many half stars to print

        $fullstarpath = '<img src=images/fullstarrating.png>';
        $halfstarpath = '<img src=images/halfstarrating.png>';
        $ratingtoprint = '';
        $ratingtoprint = str_repeat($fullstarpath, $fullStar) . str_repeat($halfstarpath, $halfStar);

        echo ' <div id="post-container-manage">                                                 
                <div class="post-text post-manage-text">        
                    <h1 class="title titleformat">' . ($row["title"]) . '</h1>
                    <div class="author-and-date">
                        <label class="date">Date: ' . date("d.m.Y", strtotime($row["publishedDate"])) . ' </label>
                        <label class="spacing">|</label>
                        <label class="author">Author: ' . ($row["userName"]) . '</label>';

        if (!empty($ratingtoprint)) {
            echo '<label class="spacing">|</label>
                                <label class="rating">Rating: ' . $ratingtoprint . '</label>';
            echo '<label class="count">&nbsp reviewed by ' . $rating_row["num_ratings"] . ''
                . ($rating_row["num_ratings"] == 1 ? ' adventurer' : ' adventurers') . ' </label> ';

            if ($images != NULL && count($images) == 2) {
                echo '<div class=image-container><img src="data:image/jpeg;base64,' . $images[0] . '" class = "manage-image">';
                echo '<img src="data:image/jpeg;base64,' . $images[1] . '" class = "manage-image"></div>';
            } else {
                if(!empty($images[0])){
                echo '<div class=image-container><img src="data:image/jpeg;base64,' . $images[0] . '" class = "manage-image">';}
            }
        } else {
            echo '<label class="spacing">|</label>
                    <label class="rating">Rating: None</label>';
                    if ($images != NULL && count($images) == 2) {
                        echo '<div class=image-container><img src="data:image/jpeg;base64,' . $images[0] . '" class = "manage-image">';
                        echo '<img src="data:image/jpeg;base64,' . $images[1] . '" class = "manage-image"></div>';
                    } else {
                        if(!empty($images[0])){
                        echo '<div class=image-container><img src="data:image/jpeg;base64,' . $images[0] . '" class = "manage-image">';}
                    }
        }

        echo '</div>
                <div class="post-label">';

        $tags = trim($row["tag"]);
        $tagsArray = explode(',', $tags); //split the tags into an array              
        //print out each tag
        foreach ($tagsArray as $tag) {
            echo '<label>#' . trim($tag) . '</label>'; // trim white space
        }
        if (isset($_SESSION['roleID']) && $_SESSION['roleID'] == 3) {
            echo '<form method="POST" action = "processphp/processmanagearchive.php">
            <input type="hidden" name = "postID" value="' . $postID . '">
            <input type="hidden" name = "status" value="1">
            <button type="submit" class="archive-post-button">Click to Archive</button>&nbsp';

            if ($counter < 4) {
                echo '<span>&nbsp&nbsp&#128308 &nbspLive on HomePage</span>';

            } else {
                
                echo '<span>&nbsp&nbsp&#128994 Active,&nbsp'.$counter2.ordinalSuffix($counter2).'&nbspin queue</span>';
                $counter2++;
                
            }

            echo '</form>';
            echo '<form method="POST" action = "processphp/processmanageinactive.php">
            <input type="hidden" name = "postID" value="' . $postID . '">
            <input type="hidden" name = "status" value="0">
            <button type="submit" class="archive-post-button active-button">Click to Inactivate</button></form>';
        }
      
        echo '</div>
                    <div class="main-content-manage">' . $row["content"] . '...                                                                                                                                                            
                    </div></div> </div><hr>';
        $counter++;
    }
}
