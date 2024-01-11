<?php
require "db.php";
//function to display x many words
function showFirstManyWords($content, $words)
{
    $content = explode(' ', $content); //split by white space
    $arrayToDisplay = array_slice($content, 0, $words); //array item 0 to 200       
    return implode(' ', $arrayToDisplay); //return array item in string and keep the space
}

$sql = "SELECT Post.*, User.userName
        FROM Post
        INNER JOIN User ON User.userID = Post.userID
        LEFT JOIN PostImage ON PostImage.postID = Post.postID
        WHERE Post.archive <> 1 and Post.inactive <> 1
        GROUP BY Post.postID
        ORDER BY publishedDate DESC 
        LIMIT 4;"; //sorted in descending order so it fetches the most recent 4 posts. Archive and inactive status cannot be true.   

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
        $rating_query = "SELECT AVG(scale) as avg_rating, COUNT(scale) as num_ratings FROM Rating WHERE postID = $postID "; //get the average rating and the number of ratings

        $image_result = $conn->query($image_query); //result querying PostImage table
        $comment_result = $conn->query($comment_query); //result querying Comment table
        $rating_result = $conn->query($rating_query); //average rating and the number of ratings

        //image retrieval reference https://stackoverflow.com/questions/10850605/display-image-from-sql
        if ($image_result && $image_result->num_rows > 0) {
            while ($image_table_row = $image_result->fetch_assoc()) {
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
        $ratingtoprint = str_repeat($fullstarpath, $fullStar) . str_repeat($halfstarpath, $halfStar);

        echo '<div class="post-box">                  
                <div class="post-image">';

        if ($images != NULL) {
            echo '<img src="data:image/jpeg;base64,' . $images[0] . '" alt="image" id="post' . $postID . '-image" class ="post-image-itself" 
            data-image2 = "' . (isset($images[1]) ? $images[1] : $images[0]) . '">';
        } else {
            echo '<img src="images/to-be-revealed.jpg" alt="image" id="post' . $postID . '-image" class ="post-image-itself">';
        }
        echo '</div>             
                <div class="post-text">        
                    <h1 class="title">' . html_entity_decode($row["title"]) . '</h1>
                    <div class="author-and-date">
                        <label class="date">Date: ' . date("d.m.Y", strtotime($row["publishedDate"])) . ' </label>
                        <label class="spacing">|</label>
                        <label class="author">Author: ' . html_entity_decode($row["userName"]) . '</label>';

        if (!empty($ratingtoprint)) {
            echo '<label class="spacing">|</label>
                <label class="rating">Rating: ' . $ratingtoprint . '</label>';
            echo '<label class="count">&nbsp reviewed by ' . $rating_row["num_ratings"] . ''
                . ($rating_row["num_ratings"] == 1 ? ' adventurer' : ' adventurers') . ' </label> ';
            if (isset($_SESSION['roleID']) && $_SESSION['roleID'] != 1) {
                echo '<button class="rate-comment-post accordiontwo">Review</button>'; //only display this option when the user is logged in
            }

        } else {
            if (isset($_SESSION['roleID']) && $_SESSION['roleID'] != 1) {
                echo '<label class="spacing">|</label>
                        <label class="rating">Rating: None</label>';
                echo '<button class="rate-comment-post accordiontwo">Review</button>'; //only display this option when the user is logged in
            } else {
                echo '<label class="spacing">|</label>
                        <label class="rating">Rating: None</label>';
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
            // echo '<button id = "post-archive-button" type="submit" class="archive-post-button">Click to Archive</button>';
            echo '<form method="POST" action = "processphp/processarchive.php">
            <input type="hidden" name = "postID" value="' . $postID . '">
            <input type="hidden" name = "status" value="1">
            <button type="submit" class="archive-post-button">Click to Archive</button>
            </form>';
        }
        //include a list of custom data attribute for javascript overlay
        echo '</div>
                    <div class="main-content">' . showFirstManyWords($row["content"], 200) . '...
                    <button class="read-more" data-title = "' . html_entity_decode($row["title"]) . '" 
                                              data-author = "' . html_entity_decode($row["userName"]) . '"
                                              data-date="' . date("d.m.Y", strtotime($row["publishedDate"])) . '" 
                                              data-tags="' . $tags . '"                                             
                                              data-postcontent="' . html_entity_decode($row["content"]) . '"';

        if (isset($images[0]) && isset($images[1])) {
            // Two images exit in database
            echo ' data-image="data:image/jpeg;base64,' . $images[0] . '"';
            echo ' data-image2="' . $images[1] . '"';
        } elseif (isset($images[0])) {
            // Only one image
            echo ' data-image="data:image/jpeg;base64,' . $images[0] . '"';
            echo ' data-image2="' . $images[0] . '"';
        } else {
            // image null
            echo ' data-image="images/to-be-revealed.jpg"';
            echo ' data-image2=" "';
        }
        echo '> Read More</button></div>';

        //handling showing comments
        $comments = '';
        if ($comment_result && $comment_result->num_rows > 0) {
            while ($comment_table_row = $comment_result->fetch_assoc()) {
                $comments .= '<h2 class = "commenter">Member: ' . html_entity_decode($comment_table_row["userName"])
                    . ',  Date: ' . date("d.m.Y", strtotime($comment_table_row["creationDate"])) .
                    ' says </h2><br>' . '<div class="comment-text">' . html_entity_decode($comment_table_row["description"]) . '</div>' . '<br>';
            }
        }

        $fullstarstring = '<span class="icon">' . $fullstarpath . '</span>';
        $halfstarstring = '<span class="icon">' . $halfstarpath . '</span>';
        $onehalfstar = $fullstarstring . $halfstarstring;
        $twostar = str_repeat($fullstarstring, 2);
        $twohalfstar = str_repeat($fullstarstring, 2) . $halfstarstring;
        $threestar = str_repeat($fullstarstring, 3);
        $threehalfstar = str_repeat($fullstarstring, 3) . $halfstarstring;
        $fourstar = str_repeat($fullstarstring, 4);
        $fourhalfstar = str_repeat($fullstarstring, 4) . $halfstarstring;
        $fivestar = str_repeat($fullstarstring, 5);

        echo '<button class = "read-comment accordion">Show Comment</button>
            <div class="comment">' . (!empty($comments) ? $comments : 'Be the first person to review the post!') . '</div>';

        if (isset($_SESSION['userID'])) {
            echo '<div class ="submit-post-review"><hr>
            <div class="review-form-title">Submit Rating and Review</div>
            <form method="POST" action="processphp/addreview.php">
                <label for="user-rating" class = "select-rating">Rating</label>
                <input type="radio" name="stars" value="1"/>' . $fullstarstring . '
                <input type="radio" name="stars" value="1.5"/>' . $onehalfstar . '
                <input type="radio" name="stars" value="2" />' . $twostar . '
                <input type="radio" name="stars" value="2.5" />' . $twohalfstar . '
                <input type="radio" name="stars" value="3" />' . $threestar . '
                <input type="radio" name="stars" value="3.5" /> ' . $threehalfstar . '
                <input type="radio" name="stars" value="4" /> ' . $fourstar . '
                <input type="radio" name="stars" value="4.5" />' . $fourhalfstar . '
                <input type="radio" name="stars" value="5" />' . $fivestar . '<br>
                <label for="review">Review</label><br>
                <textarea name="review" class="user-post-review" placeholder="Share your thoughts!"></textarea>
                <input type="hidden" name="postID" value="' . $postID . '">
                <input type="hidden" name="userID" value="' . $_SESSION['userID'] . '"> 
                <div><span class="error-message-to-display"></span>           
                <button type="submit" class="review-submit-button">Submit</button> </div>                
            </form>          
            </div>';
        }
        echo '</div></div> ';
    }
}

if (isset($conn)) {
    $conn->close();
}
?>