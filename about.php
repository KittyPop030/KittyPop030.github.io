<?php
require_once 'logout.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'displaywelcomemessage.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Henry Croft, Matthew Laughlin, Alicia Chan">
    <title> About </title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="x-icon" href="images/BrouserTabIcon.png">
    <script type="text/JavaScript" src="functionality js/darkmode.js" defer></script>
    <script type="text/JavaScript" src="functionality js/functionalities.js" defer></script>
    <script type="text/JavaScript" src="functionality js/musictoggle.js" defer></script>
    <script type="text/JavaScript" src="functionality js/showstudent.js" defer></script>
</head>

<body>
    <header>
        <div class="image-text-section">
            <img class="header-image" id="image-header" src="images/fish%20for%20about.jpg" alt="clownfish-Image-for-header">
            <div class="centered-text">about</div>
            <div class="welcome-text">
                <?php if (isset($_SESSION['username'])) {
                    echo $messageToDisplayToUser;
                } ?><!--display welcome message-->
            </div>
        </div>
        <img id="logo" src="images/logo.jpg" alt="site-logo">
        <nav class="navigation">
            <ul>
                <?php if (isset($_SESSION['username'])) { ?>
                    <li><a href="?logout=1" class="logout-link">Logout</a></li>
                <?php } ?>
                <?php if (isset($_SESSION['roleID']) && $_SESSION['roleID'] == 3) { ?>
                    <li><a href="member.php">Manage</a></li>
                <?php } ?>
                <?php if (isset($_SESSION['username']) && $_SESSION['roleID'] != 1) { ?>
                    <li><a href="archive.php">Post Archive</a></li>
                <?php } ?>
                <?php if (!isset($_SESSION['username'])) { ?>
                    <li><a href="register.php"> Register</a></li>
                <?php } ?>
                <?php if (!isset($_SESSION['username'])) { ?>
                    <li><a href="login.php"> Login</a></li>
                <?php } ?>
                <?php if (isset($_SESSION['roleID']) && $_SESSION['roleID'] == 3) { ?>
                    <li><a href="create.php"> Create Post</a></li>
                <?php } ?>
                <li class="active"><a href="about.php" class="active"> About</a></li>
                <li><a href="index.php"> HomePage </a></li>
            </ul>
            <ul>
                <li class="collapsible">NAV</li>
            </ul>
        </nav>
        <img src="images/moon-2.png" id="switch" alt="switch on dark mode or light mode">
        <div class="displayMode">DarkMode</div>
        <div class="audio_control">
            <button id="audio-button">
                <span class="play"></span>
            </button>
            <audio src="music/deepSea.mp3" id="music"></audio>
        </div>
    </header>
    <div class="about-container">
        <div class="first-section">
            <div class="story-section">
                <h1 id="about-us">Story</h1>
                <div id="story-text">Welcome to "Fin-Tastic Finds!" We're three students from the University of Tasmania
                    captivated
                    by the ocean's wonders. What started as our shared passion has evolved into this community space
                    where,
                    just like us, you can share your stories, insights, and marine discoveries. From amazing marine life
                    to mysterious tales of shipwrecks, our blog is more than just a platform — it is a shared voyage. If
                    you're
                    enthusiastic about the ocean and looking to connect with like-minded explorers, you've just found
                    your
                    harbour.
                    Dive in, share, and connect with a wave of ocean lovers!
                </div>
                <div class="picture-section">
                    <div id="stu1" class="student-1"><img src="images/mario.png" alt="henry">
                        <div>Co-founder</div>
                        <div class="stu-description">Henry Croft</div>
                        <div class="stu-id">575771</div>
                    </div>
                    <div id="stu2" class="student-2"><img src="images/Toad.png" alt="matthew">
                        <div>Co-founder</div>
                        <div class="stu-description">Matthew Laughlin</div>
                        <div class="stu-id">620636</div>
                    </div>
                    <div id="stu3" class="student-3"><img src="images/Rosalina.png" alt="alicia">
                        <div>Co-founder</div>
                        <div class="stu-description">Alicia Chan</div>
                        <div class="stu-id">554804</div>
                    </div>
                </div>
            </div>
            <div class="second-section">
                <hr><!--insert a horizontal line as separator-->
                <div class="references">
                    <h1>Account and Password</h1>
                    <span>Username:&nbsp admin &nbsp Password:&nbsp!Fintasticfindsadminaccount123</span>
                    <span>Username: &nbspmember &nbsp Password:&nbsp!Fintasticfindsmemberaccount123</span>
                    <h1 id="references">References and Embellishments</h1>
                    <div class="sub-item">Tutorial References</div>
                    <h4>Assignment 1</h4>
                    <span>Navigation Bar Demo</span>
                    <a href="https://www.w3schools.com/css/css_navbar_horizontal.asp">https://www.w3schools.com/css/css_navbar_horizontal.asp</a>
                    <span>Navigation Bar Demo</span>
                    <a href="https://www.w3schools.com/css/css_navbar.asp">https://www.w3schools.com/css/css_navbar.asp</a>
                    <span>JavaScript Form Validation With Limit Login Attempts</span>
                    <a href="https://www.formget.com/javascript-login-form/">https://www.formget.com/javascript-login-form/</a>
                    <span>How to create your first login page with HTML, CSS and JavaScript</span>
                    <a href="https://medium.com/swlh/how-to-create-your-first-login-page-with-html-css-and-javascript-602dd71144f1">https://medium.com/swlh/how-to-create-your-first-login-page-with-html-css-and-javascript-602dd71144f1</a>
                    <span>How to make a website light/dark toggle with CSS & JS</span>
                    <a href="https://www.youtube.com/watch?v=wodWDIdV9BY&t=848s">https://www.youtube.com/watch?v=wodWDIdV9BY&t=848s</a>
                    <span>How To Make Website DARK MODE | Dark Theme Website Design Using HTML, CSS & JS</span>
                    <a href="https://www.youtube.com/watch?v=9LZGB3OLXNQ&t=531s">https://www.youtube.com/watch?v=9LZGB3OLXNQ&t=531s</a>
                    <span>box-shadow</span>
                    <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/box-shadow">https://developer.mozilla.org/en-US/docs/Web/CSS/box-shadow</a>
                    <span>Javascript audio play pause</span>
                    <a href="https://www.w3schools.com/jsref/met_audio_pause.asp">https://www.w3schools.com/jsref/met_audio_pause.asp</a>
                    <span>onscroll Event</span>
                    <a href="https://www.w3schools.com/jsref/event_onscroll.asp">https://www.w3schools.com/jsref/event_onscroll.asp</a>
                    <span>Learn Flexbox CSS in 8 minutes</span>
                    <a href="https://www.youtube.com/watch?v=phWxA89Dy94&t=41s">https://www.youtube.com/watch?v=phWxA89Dy94&t=41s</a>
                    <span>Learn flexbox the easy way</span>
                    <a href="https://www.youtube.com/watch?v=u044iM9xsWU&t=830s">https://www.youtube.com/watch?v=u044iM9xsWU&t=830s</a>
                    <span>Animating with CSS Transitions - A look at the transition properties</span>
                    <a href="https://www.youtube.com/watch?v=Nloq6uzF8RQ&t=449ss">https://www.youtube.com/watch?v=Nloq6uzF8RQ&t=449s</a>
                    <span>10 CSS animation tips and tricks</span>
                    <a href="https://www.youtube.com/watch?v=y8-F5-2EIcg">https://www.youtube.com/watch?v=y8-F5-2EIcg</a>
                    <span>:root</span>
                    <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/:root">https://developer.mozilla.org/en-US/docs/Web/CSS/:root</a>
                    <span>JavaScript for…of Loop</span>
                    <a href="https://www.javascripttutorial.net/es6/javascript-for-of/">https://www.javascripttutorial.net/es6/javascript-for-of/</a>
                    <span>JavaScript for of | Explained</span>
                    <a href="https://linuxhint.com/javascript-for-of-explained/">https://linuxhint.com/javascript-for-of-explained/</a>
                    <h4>NEW! Assignment 2</h4>
                    <span>How TO create different shapes with CSS</span>
                    <a href="https://www.w3schools.com/howto/howto_css_shapes.asp">https://www.w3schools.com/howto/howto_css_shapes.asp</a>
                    <span>NEW! mysql_insert_id</span>
                    <a href="https://www.php.net/manual/en/function.mysql-insert-id.php">https://www.php.net/manual/en/function.mysql-insert-id.php</a>
                    <span>NEW! PHP File Upload to Server with MySQL Database</span>
                    <a href="https://www.codexworld.com/upload-store-image-file-in-database-using-php-mysql/">https://www.codexworld.com/upload-store-image-file-in-database-using-php-mysql/</a>
                    <span>NEW! PHP Login Script with Session</span>
                    <a href="https://phppot.com/php/php-login-script-with-session/">https://phppot.com/php/php-login-script-with-session/</a>
                    <span>NEW! PHP List of Supported Timezones</span>
                    <a href="https://www.php.net/manual/en/timezones.php">https://www.php.net/manual/en/timezones.php</a>
                    <span>NEW! PHP date_default_timezone_set</span>
                    <a href="https://www.php.net/manual/en/function.date-default-timezone-set.php">https://www.php.net/manual/en/function.date-default-timezone-set.php</a>
                    <span>NEW! PHP explode() Function</span>
                    <a href="https://www.geeksforgeeks.org/php-explode-function/">https://www.geeksforgeeks.org/php-explode-function/</a>
                    <span>NEW! SQL INNER JOIN Keyword</span>
                    <a href="https://www.w3schools.com/sql/sql_join_inner.asp">https://www.w3schools.com/sql/sql_join_inner.asp</a>
                    <span>NEW! strtotime</span>
                    <a href="https://www.php.net/manual/en/function.strtotime.php">https://www.php.net/manual/en/function.strtotime.php</a>

                    <span>NEW! How to limit array values in implode output</span>
                    <a href="https://stackoverflow.com/questions/18662113/how-to-limit-array-values-in-implode-output">https://stackoverflow.com/questions/18662113/how-to-limit-array-values-in-implode-output</a>
                    <span>NEW! Display image from sql</span>
                    <a href="https://stackoverflow.com/questions/10850605/display-image-from-sql">https://stackoverflow.com/questions/10850605/display-image-from-sql</a>
                    <span>NEW! HTML5 Custom Data Attributes (data-*)</span>
                    <a href="http://html5doctor.com/html5-custom-data-attributes/">http://html5doctor.com/html5-custom-data-attributes/</a>
                    <span>NEW! How TO - Collapsibles/Accordion</span>
                    <a href="https://www.w3schools.com/howto/howto_js_accordion.asp">https://www.w3schools.com/howto/howto_js_accordion.asp</a>
                    <span>NEW! How TO - Using data attributes</span>
                    <a href="https://developer.mozilla.org/en-US/docs/Learn/HTML/Howto/Use_data_attributes">https://developer.mozilla.org/en-US/docs/Learn/HTML/Howto/Use_data_attributes</a>
                    <span>NEW! How to Use setTimeout() in JavaScript</span>
                    <a href="https://www.freecodecamp.org/news/javascript-settimeout-how-to-set-a-timer-in-javascript-or-sleep-for-n-seconds/">https://www.freecodecamp.org/news/javascript-settimeout-how-to-set-a-timer-in-javascript-or-sleep-for-n-seconds/</a>
                    <span>NEW! How to clear browser cache with php?</span>
                    <a href="https://stackoverflow.com/questions/1037249/how-to-clear-browser-cache-with-php">https://stackoverflow.com/questions/1037249/how-to-clear-browser-cache-with-php</a>

                    <div class="sub-item">Images</div>
                    <h4>Assignment 1</h4>
                    <span>Adobe Logo Maker</span>
                    <a href="https://express.adobe.com/express-apps/logo-maker/">https://express.adobe.com/express-apps/logo-maker/</a>
                    <span>Turtle image for post archive header</span>
                    <a href="https://www.wallpaperflare.com/sea-turtle-in-water-underwater-photography-of-brown-sea-turtle-wallpaper-zttod">
                        https://www.wallpaperflare.com/sea-turtle-in-water-underwater-photography-of-brown-sea-turtle-wallpaper-zttod</a>
                    <span>Turtle image for homePage content</span>
                    <a href="https://goldcoastdiveadventures.com.au/sea-turtles-species-facts/">https://goldcoastdiveadventures.com.au/sea-turtles-species-facts/</a>
                    <span>Register Page Header Image</span>
                    <a href="https://www.hdwallpapers.in/coral_reef_stones_schooling_of_fish_underwater_4k_hd_nature-wallpapers.html">https://www.hdwallpapers.in/coral_reef_stones_schooling_of_fish_underwater_4k_hd_nature-wallpapers.html</a>
                    <span>Create Post Page Header Image</span>
                    <a href="https://www.pxfuel.com/en/desktop-wallpaper-tntti">https://www.pxfuel.com/en/desktop-wallpaper-tntti</a>
                    <span>Login Page Header Image</span>
                    <a href="https://wallpapercrafter.com/885623-fishes-high-life-ocean-resolution-silhouette-1080p.html">https://wallpapercrafter.com/885623-fishes-high-life-ocean-resolution-silhouette-1080p.html</a>
                    <span>HomePage Header Image</span>
                    <a href="https://www.keywestaquarium.com/clownfish">https://www.keywestaquarium.com/clownfish</a>
                    <span>About Page Header Image</span>
                    <a href="https://www.aims.gov.au/reef-monitoring/gbr-condition-summary-2018-2019">https://www.aims.gov.au/reef-monitoring/gbr-condition-summary-2018-2019</a>
                    <span>Sun Icon</span>
                    <a href="https://www.flaticon.com/search?type=icon&search-group=all&word=sun&license=&color=&shape=&current_section=&author_id=&pack_id=&family_id=&style_id=&type=">
                        https://www.flaticon.com/search?type=icon&search-group=all&word=sun&license=&color=&shape=&current_section=&author_id=&pack_id=&family_id=&style_id=&type=</a>
                    <span>Beluga image for homePage content</span>
                    <a href="https://goodness-exchange.com/beluga-whale-frienship/">https://goodness-exchange.com/beluga-whale-frienship/</a>
                    <span>Background Texture</span>
                    <a href="https://www.toptal.com/designers/subtlepatterns/waves-of-value/">https://www.toptal.com/designers/subtlepatterns/waves-of-value/</a>
                    <span>Titanic Wreck image for homePage content</span>
                    <a href="https://en.wikipedia.org/wiki/Wreck_of_the_Titanic#/media/File:Titanic_wreck_bow.jpg">https://en.wikipedia.org/wiki/Wreck_of_the_Titanic#/media/File:Titanic_wreck_bow.jpg</a>
                    <span>SeaTurtle image for HomePage content</span>
                    <a href="https://a-z-animals.com/blog/the-worlds-oldest-sea-turtle/">https://a-z-animals.com/blog/the-worlds-oldest-sea-turtle/</a>
                    <span>Beluga image for HomePage</span>
                    <a href="https://www.animalspot.net/beluga-whale.html">https://www.animalspot.net/beluga-whale.html</a>
                    <span>Titanic picture for HomePage</span>
                    <a href="https://www.lifestyleasia.com/sg/entertainment/movies/the-true-story-behind-james-cameron-movie-titanic/">https://www.lifestyleasia.com/sg/entertainment/movies/the-true-story-behind-james-cameron-movie-titanic/</a>
                    <span>Nintendo Mario Picture for About</span>
                    <a href=" https://en.wikipedia.org/wiki/Mario">https://en.wikipedia.org/wiki/Mario</a>
                    <span>Nintendo Toad Picture for About</span>
                    <a href=" https://en.wikipedia.org/wiki/Toad_(Nintendo)#">
                        https://en.wikipedia.org/wiki/Toad_(Nintendo)#</a>
                    <span>Nintendo Rosalina Picture for About</span>
                    <a href=" https://en.wikipedia.org/wiki/Rosalina_%28Mario%29 ">
                        https://en.wikipedia.org/wiki/Rosalina_%28Mario%29 </a>
                    <span>Black Swan Treasure picture for archive content1</span>
                    <a href="https://www.trendhunter.com/trends/world-record-treasure-black-swan-shipwreck-yields-500-million-dollar-treasu">
                        https://www.trendhunter.com/trends/world-record-treasure-black-swan-shipwreck-yields-500-million-dollar-treasu</a>
                    <span>Blue Whale Picture for archive2</span>
                    <a href="https://animals.howstuffworks.com/mammals/blue-whale.htm">https://animals.howstuffworks.com/mammals/blue-whale.htm</a>
                    <span>Jellyfish picture for archive3</span>
                    <a href="https://www.istockphoto.com/search/2/image?phrase=jelly+fish">https://www.istockphoto.com/search/2/image?phrase=jelly+fish</a>
                    <span>Ray for archive4</span>
                    <a href="https://www.dogcatplace.com/wildanimals/the-ocean-sting-ray-facts">https://www.dogcatplace.com/wildanimals/the-ocean-sting-ray-facts</a>
                    <span>Marina trench for archive5</span>
                    <a href="https://geographical.co.uk/science-environment/geo-explainer-exploring-the-mariana-trench">https://geographical.co.uk/science-environment/geo-explainer-exploring-the-mariana-trench</a>
                    <span>Moon icon</span>
                    <a href="https://www.flaticon.com/free-icon/moon_10763330">https://www.flaticon.com/free-icon/moon_10763330</a>
                    <span>Second Beluga for Homepage content</span>
                    <a href="https://www.worldwildlife.org/species/https://www.worldwildlife.org/species/belugabeluga">https://www.worldwildlife.org/species/beluga</a>
                    <span>Humphead Wrasse Homepage Post 4</span>
                    <a href="https://www.nationalgeographic.com/animals/article/facial-recognition-humphead-wrasse-disappearing">https://www.nationalgeographic.com/animals/article/facial-recognition-humphead-wrasse-disappearing</a>
                    <span>Humphead Wrasse Homepage Post 4</span>
                    <a href="https://www.cairnsdiscounttours.com.au/tours/cairnsdiving/">https://www.cairnsdiscounttours.com.au/tours/cairnsdiving/</a>
                    <span>Second Titanic picture Homepage Post</span>
                    <a href="https://www.bbc.com/future/article/20230620-why-the-waters-around-the-titanic-are-still-treacherous">https://www.bbc.com/future/article/20230620-why-the-waters-around-the-titanic-are-still-treacherous</a>

                    <h4>NEW! Assignment 2</h4>
                    <span>NEW! Question Mark formed by fish for no image post</span>
                    <a href="https://www.msc.org/en-au/for-teachers/ocean-literacy/ask-an-expert">https://www.msc.org/en-au/for-teachers/ocean-literacy/ask-an-expert</a>

                    <span>NEW! Rating Star Icon</span>
                    <a href="https://www.flaticon.com/free-icons/star-rating">https://www.flaticon.com/free-icons/star-rating</a>

                    <span>NEW! Unicode Character Red Circle</span>
                    <a href="https://www.compart.com/en/unicode/U+1F534">https://www.compart.com/en/unicode/U+1F534</a>
                    <span>NEW! Unicode Character Green Circle</span>
                    <a href="https://www.compart.com/en/unicode/U+1F7E2">https://www.compart.com/en/unicode/U+1F7E2</a>
                    <span>NEW! Unicode Character Water Wave</span>
                    <a href="https://emojipedia.org/water-wave">https://emojipedia.org/water-wave</a>
                    <span>NEW! GiantSquid1</span>
                    <a href="https://www.telegraph.co.uk/science/2017/11/03/blue-planet-ii-giant-cannibalistic-squid-filmed-hunting-packs/">https://www.telegraph.co.uk/science/2017/11/03/blue-planet-ii-giant-cannibalistic-squid-filmed-hunting-packs/</a>
                    <span>NEW! GiantSquid2</span>
                    <a href="https://disney.fandom.com/wiki/Giant_Squid_(Finding_Nemo)">https://disney.fandom.com/wiki/Giant_Squid_(Finding_Nemo)</a>
                    <span>NEW! Seahorse1</span>
                    <a href="https://faithgateway.com/blogs/christian-books/see-the-seahorse">https://faithgateway.com/blogs/christian-books/see-the-seahorse</a>
                    <span>NEW! Seahorse2</span>
                    <a href="https://www.treehugger.com/nature-blows-my-mind-seahorses-are-one-deadliest-creatures-sea-yes-seahorses-4858626">https://www.treehugger.com/nature-blows-my-mind-seahorses-are-one-deadliest-creatures-sea-yes-seahorses-4858626</a>
                    <span>NEW! Submersible1</span>
                    <a href="https://www.lifestyleasia.com/hk/entertainment/titantic-submarine-titan-documentary-channel-5-released/">https://www.lifestyleasia.com/hk/entertainment/titantic-submarine-titan-documentary-channel-5-released/</a>
                    <span>NEW! Submersible2</span>
                    <a href="https://www.nytimes.com/2023/06/20/us/missing-submarine-titanic-search.html">https://www.nytimes.com/2023/06/20/us/missing-submarine-titanic-search.html</a>
                    <span>NEW! Black Swan Project</span>
                    <a href="https://www.ancient-origins.net/history/black-swan-project-controversy-strikes-after-enormous-treasure-hoard-retrieved-spanish-wreck-020495">https://www.ancient-origins.net/history/black-swan-project-controversy-strikes-after-enormous-treasure-hoard-retrieved-spanish-wreck-020495</a>
                    <span>NEW! Bluewhale2</span>
                    <a href="https://www.cybersmile.org/blog/everything-you-need-to-know-about-the-blue-whale-challenge">https://www.cybersmile.org/blog/everything-you-need-to-know-about-the-blue-whale-challenge</a>

                    <span>NEW! Brouser Tab Icon</span>
                    <a href="https://www.veryicon.com/icons/food--drinks/the-first-business-material-design/fish-26.html">https://www.veryicon.com/icons/food--drinks/the-first-business-material-design/fish-26.html</a>
                    <span>NEW! Mariana Trench</span>
                    <a href="https://www.thoughtco.com/facts-about-the-mariana-trench-2291766">https://www.thoughtco.com/facts-about-the-mariana-trench-2291766</a>

                    <span>NEW! Finding Neemo</span>
                    <a href="https://www.insider.com/real-facts-in-finding-nemo-pixar-movie-2019-6">https://www.insider.com/real-facts-in-finding-nemo-pixar-movie-2019-6</a>
                    <span>NEW! Neemo 2</span>
                    <a href="https://a-z-animals.com/blog/5-finding-nemo-fish-species-in-real-life/">https://a-z-animals.com/blog/5-finding-nemo-fish-species-in-real-life/</a>
                    <span>NEW! Caribbean Sea</span>
                    <a href="https://www.worldatlas.com/seas/caribbean-sea.html">https://www.worldatlas.com/seas/caribbean-sea.html</a>

                    <span>NEW! Atlantic Ocean</span>
                    <a href="https://www.kids-world-travel-guide.com/atlantic-ocean-facts.html">https://www.kids-world-travel-guide.com/atlantic-ocean-facts.html</a>
                    <span>NEW! Coral Conservation1</span>
                    <a href="https://www.conservationfinancealliance.org/gfcr">https://www.conservationfinancealliance.org/gfcr</a>
                    <span>NEW! Coral Conservation2</span>
                    <a href="https://www.gpsworld.com/coral-reef-conservation-technology-wins-copernicus-masters-2020-competition/">https://www.gpsworld.com/coral-reef-conservation-technology-wins-copernicus-masters-2020-competition/</a>
                    <span>NEW! Disney Mermaid</span>
                    <a href="https://www.dailymaverick.co.za/article/2023-06-08-disneys-black-mermaid-is-no-breakthrough-just-look-at-the-literary-subgenre-of-black-mermaid-fiction/">https://www.dailymaverick.co.za/article/2023-06-08-disneys-black-mermaid-is-no-breakthrough-just-look-at-the-literary-subgenre-of-black-mermaid-fiction/</a>
                    <span>NEW! Mermaid2</span>
                    <a href="https://stock.adobe.com/search/images?k=mermaid">https://stock.adobe.com/search/images?k=mermaid</a>
                    <span>NEW! Jellyfish1</span>
                    <a href="https://stock.adobe.com/search?k=%22jelly+fish%22&asset_id=574960312">https://stock.adobe.com/search?k=%22jelly+fish%22&asset_id=574960312</a>
                    <span>NEW! Jellyfish2</span>
                    <a href="https://pixabay.com/photos/jellyfish-wallpaper-jelly-fish-4949516/">https://pixabay.com/photos/jellyfish-wallpaper-jelly-fish-4949516/</a>

                    <div class="sub-item">Colour</div>
                    <span>CSS Colour</span>
                    <a href="https://www.w3schools.com/css/css3_colors.asp">https://www.w3schools.com/css/css3_colors.asp</a>
                    <span>Gradiant Colour</span>
                    <a href="https://www.makeuseof.com/css-background-gradients/">https://www.makeuseof.com/css-background-gradients/</a>
                    <span>CSS Gradient</span>
                    <a href="https://cssgradient.io/">https://cssgradient.io/</a>
                    <span>Eggradients</span>
                    <a href="https://www.eggradients.com/gradient/cherry-season">https://www.eggradients.com/gradient/cherry-season</a>

                    <div class="sub-item">Music</div>
                    <h4>Assignment 1</h4>
                    <span>Deep Sea Music</span>
                    <a href="https://www.youtube.com/watch?v=OVct34NUk3U&t=1375s">https://www.youtube.com/watch?v=OVct34NUk3U&t=1375s</a>
                    <div class="sub-item">Filler Text</div>
                    <span>Generate Lorem Ipsum placeholder text</span>
                    <a href="https://loremipsum.io/generator/?n=700&t=w">https://loremipsum.io/generator/?n=700&t=w</a>
                    <div class="sub-item" id="embellishments">List of Embellishments</div>
                    <h4>From Assignment 1</h4>
                    <span>Scroll to top button appears once the user starts scrolling</span>
                    <span>Option to play music and toggle play/pause</span>
                    <span>Choice between light and dark theme</span>
                    <span>Navigation bar sticks to the top and collapses once scrolling past the header</span>
                    <span>Additional CSS reveal animation</span>
                    <span>Responsive design</span>
                    <span>Pop up overlay for posts on Homepage - "Read More" functionality</span>
                    <h4>NEW! Assignment 2</h4>
                    <span>Support for image</span>
                    <span>Dynamic Welcome Message</span>
                    <span>Rating and Commenting System</span>
                    <span>Archive, unarchive and inactivate post</span>
                    <span>Site manager - toggle post status, approve review, manage/update user role</span>
                    <span>favicon</span>
                </div>
            </div>
        </div>
        <div class="scroll" id="scrolling">
            <button class="scroll-to-top-button" id="scroll-to-top">
                <span id="arrow">></span>
            </button>
        </div>
    </div>
</body>

</html>