<?php 
session_start();
include ('conn.php');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // these make sure the login feedback message on login is only displayed once, and isn't shown again if a user clicks the browser back arrow (found on stack overflow)
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(isset($_SESSION['login_message'])) { // this will be used to display success messages
{
    ?>
    <div class = "logintoast"> <?php echo $_SESSION['login_message'];?></div>
    <?php

    unset($_SESSION['login_message']);
}
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Junior Movies</title>
    <link rel="stylesheet" href="css/juniorstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<nav class="navbar"><!-- junior navbar -->
        <div class="container">
            <div class="logo">Limelight Cinema</div>
            
            <div class="nav-links">
                <a href="juniorindex.php">Home</a>
                <a href="juniormovies.php" class="nav-active">Movies</a>
                <a href="juniorquiz.php">Quiz</a>
            </div>
            
            <div class="nav-group">
                <?php if (isset($_SESSION['junior_login'])): ?>
                    <a href="juniorlogout.php" class="logout-btn">Sign out</a>
                <?php endif; ?>
                <button class="menu-toggle">☰</button>
            </div>
        </div>
    </nav><!-- enf of junior navbar -->

    <div class="movieshero"><!--junior movies page hero -->
    <div class="movieshero-overlay"></div>
    <div class="movieshero-content">
        <h1>Magical Movies Await!</h1>
        <p>Discover amazing adventures, laugh-out-loud comedies, and heartwarming stories perfect for young movie lovers.</p>
        <div class="movieshero-rating-info">
            <i class="fas fa-info-circle"></i>
            <p>All movies are rated U or PG for your family's enjoyment</p>
        </div>
    </div>
</div><!--end of junior movies page hero -->

<div class="moviessearch-container">
    <div class="moviessearch-wrapper">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search movies..." id="moviessearch-input">
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


<div class="moviescoming-container">
    <div class="moviessection-header">
        <h2>Coming Soon</h2>
    </div>
    <div class="container">
        <div class="movie-grid">
            <?php
            $query = "SELECT FilmID, FilmTitle, Filmdesc, thumbnail_img, poster_img, AgeRating, Runtime 
                      FROM LimelightFilms 
                      WHERE AgeRating IN ('U', 'PG') 
                      AND Coming_Soon = 'Yes' 
                      ORDER BY FilmID DESC";
                      
            $result = mysqli_query($conn, $query);

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

<div class="moviesquiz-cta">
    <div class="moviesquiz-banner">
        <div class="moviesquiz-text">
            <h2>Take Our Movie Quiz!</h2>
            <p>Think you know your films? Test your knowledge here!</p>
        </div>
        <a href="juniorquiz.php" class="moviesquiz-button">
            Start Quiz <i class="fas fa-arrow-right"></i>
        </a>
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