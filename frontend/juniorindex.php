<?php 
session_start();
include ('conn.php');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // these make sure the login feedback message on login is only displayed once, and isn't shown again if a user clicks the browser back arrow (found on stack overflow)
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(isset($_SESSION['junior_message'])) { // this will be used to display success messages
{
    ?>
    <div class = "logintoast"> <?php echo $_SESSION['junior_message'];?></div>
    <?php

    unset($_SESSION['junior_message']);
}
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Junior Home Page</title>
    <link rel="stylesheet" href="css/juniorstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome icons -->
</head>
<body>
<nav class="navbar">
        <div class="container">
            <div class="logo">Limelight Cinema</div>
            
            <div class="nav-links">
                <a href="juniorindex.php" class="nav-active">Home</a>
                <a href="juniormovies.php">Movies</a>
                <a href="juniorquiz.php">Quiz</a>
            </div>
            
            <div class="nav-group">
                <?php if (isset($_SESSION['junior_login'])): ?>
                    <a href="juniorlogout.php" class="logout-btn">Sign out</a>
                <?php endif; ?>
                <button class="menu-toggle">☰</button>
            </div>
        </div>
    </nav>

    <div class="hero">
    <div class="hero-content">
        <h1>Welcome to Limelight Junior!</h1>
        <p>Your magical movie adventure starts here!</p>
    </div>
</div>




<?php
// Query to get movies suitable for juniors (PG and U ratings)
$query = "SELECT FilmID, FilmTitle, Filmdesc, thumbnail_img, poster_img, AgeRating, Runtime 
          FROM LimelightFilms 
          WHERE AgeRating IN ('U', 'PG') 
          AND Coming_Soon = 'No' 
          ORDER BY FilmID DESC";
          
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!-- Section Title -->
<h2 class="section-title">
    <i class="fas fa-film"></i>
    Now Showing
</h2>

<!-- Movie Section -->
<div class="now-showing">
    <div class="container">
        <div class="movie-grid">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <a href="juniormoviedetails.php?id=<?php echo $row['FilmID']; ?>" class="movie-card">
                    <div class="movie-image" style="background-image: url('<?php echo $row['thumbnail_img']; ?>');"></div>
                    <div class="movie-content">
                        <div class="movie-header">
                            <h3><?php echo $row['FilmTitle']; ?></h3>
                            <div class="movie-meta">
                                <span class="age-rating"><?php echo $row['AgeRating']; ?></span>
                                <span class="runtime">
                                    <i class="fas fa-clock"></i>
                                    <?php echo $row['Runtime']; ?> mins
                                </span>
                            </div>
                        </div>
                        <p class="movie-description"><?php echo substr($row['Filmdesc'], 0, 150) . '...'; ?></p>
                        <div class="read-more">
                            Click to learn more
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </a>
            <?php
            }
            ?>
        </div>
    </div>
</div>


<div class="funzone-section"><!-- junior fun zone section -->
        <div class="funzone-header">
            <h2 class="funzone-title">🎬 Fun Zone 🎮</h2>
            <p class="funzone-subtitle">Discover exciting movie trailers and test your film knowledge!</p>
        </div>
        
        <div class="funzone-card-container">
            <div class="funzone-card">
                <div class="funzone-card-icon">🎥</div>
                <h3 class="funzone-card-title">Movie Trailers</h3>
                <p class="funzone-card-description">Watch the latest and most exciting trailers for upcoming movies. Get ready for adventure!</p>
                <a href="juniormovies.php" class="funzone-card-link">Watch Now</a>
            </div>

            <div class="funzone-card">
                <div class="funzone-card-icon">🎯</div>
                <h3 class="funzone-card-title">Movie Quiz</h3>
                <p class="funzone-card-description">Challenge yourself with our fun movie quizzes and show off your cinema knowledge!</p>
                <a href="juniorquiz.php" class="funzone-card-link">Play Quiz</a>
            </div>
        </div>
    </div><!-- end of junior fun zone section -->


<!-- Movie Facts Section -->
<div class="movie-facts">
    <div class="movie-facts-header">
        <h2 class="section-title">
            <i class="fas fa-lightbulb"></i>
            Movie Magic Facts
        </h2>
        <p class="movie-facts-subtitle">Discover amazing facts about your favorite movies!</p>
    </div>

    <div class="facts-container">
        <!-- Film Making Card -->
        <div class="fact-card filmmaking">
            <div class="fact-icon">
                <i class="fas fa-video"></i>
            </div>
            <h3>How Movies Are Made</h3>
            <div class="fact-content">
                <p>Did you know that a single movie can take hundreds of people to make? From directors and actors to special effects artists and costume designers, every person plays an important role in creating movie magic!</p>
            </div>
        </div>

        <!-- Animation Card -->
        <div class="fact-card animation">
            <div class="fact-icon">
                <i class="fas fa-paint-brush"></i>
            </div>
            <h3>Animation Magic</h3>
            <div class="fact-content">
                <p>Animation movies can take 4-5 years to make! Each second of an animated film contains 24 different images. That means a 90-minute animated movie needs over 129,000 images!</p>
            </div>
        </div>

        <!-- Sound Effects Card -->
        <div class="fact-card sound">
            <div class="fact-icon">
                <i class="fas fa-music"></i>
            </div>
            <h3>Movie Sounds</h3>
            <div class="fact-content">
                <p>Many movie sounds are created using everyday objects! For example, the famous lightsaber sound in Star Wars comes from TV interference and movie projector motors. Movie magic is everywhere!</p>
            </div>
        </div>
    </div>
</div>


<!-- Footer Section -->
<footer class="junior-footer">
    <div class="footer-container">
        <!-- Main Footer Content -->
        <div class="footer-content">
            <!-- Logo Section -->
            <div class="footer-logo-section">
                <h2 class="footer-logo">Limelight Cinema</h2>
                <p class="footer-tagline">Your magical movie adventure!</p>
            </div>

            <!-- Navigation Links -->
            <div class="footer-nav">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="juniorindex.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="juniormovies.php"><i class="fas fa-film"></i> Movies</a></li>
                    <li><a href="juniorquiz.php"><i class="fas fa-question-circle"></i> Quiz</a></li>
                </ul>
            </div>

            <!-- Fun Facts Section -->
            <div class="footer-facts">
                <h3>Did You Know?</h3>
                <p>The first movie ever made was less than 1 minute long!</p>
                <div class="footer-mascot">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <p>© 2025 Limelight Cinema Junior. Let's make movie magic together! <i class="fas fa-magic"></i></p>
        </div>
    </div>
</footer>

<script src = "js/junior.js"></script>
</body>
</html>