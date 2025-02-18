<?php
session_start();
include('conn.php');


// Get user info to check member type
$user_id = $_SESSION['junior_login'];
$userQuery = "SELECT member_type, preferred_cinema FROM LimelightMembers WHERE ID = '$user_id'";
$userResult = mysqli_query($conn, $userQuery);
$userInfo = mysqli_fetch_assoc($userResult);


// Get movie details
if(isset($_GET['id'])) {
    $filmId = $_GET['id'];
    $movieQuery = "SELECT * FROM LimelightFilms WHERE FilmID = '$filmId' AND Coming_Soon = 'No'";
    $movieResult = mysqli_query($conn, $movieQuery);
    $movie = mysqli_fetch_assoc($movieResult);

    if(!$movie) {
        $_SESSION['booking_error'] = "Movie not found or not available for booking";
        header("Location: movies.php");
        exit();
    }

    // Get showtimes for user's preferred cinema
    $preferredCinema = $userInfo['preferred_cinema'];
    
    // Get the cinema ID first
    $cinemaQuery = "SELECT CinemaID FROM Cinemas WHERE CinemaName LIKE '%$preferredCinema%'";
    $cinemaResult = mysqli_query($conn, $cinemaQuery);
    $cinema = mysqli_fetch_assoc($cinemaResult);

    if($cinema) {
        $showtimesQuery = "SELECT ShowDate, ShowTime 
                   FROM Showtimes
                   WHERE FilmID = '$filmId' 
                   AND CinemaID = '{$cinema['CinemaID']}'
                   AND ShowDate >= CURDATE()
                   ORDER BY ShowDate ASC, ShowTime ASC";
        
        $showtimesResult = mysqli_query($conn, $showtimesQuery);
    }
}


// Toast messages
if(isset($_SESSION['newsletter_message'])) {
    ?>
    <div class="logintoast"> 
        <?php echo $_SESSION['newsletter_message']; ?>
    </div>
    <?php
    unset($_SESSION['newsletter_message']);
}

if(isset($_SESSION['booking_success'])) { // this will be used to display success messages
    {
        ?>
        <div class = "logintoast"> <?php echo $_SESSION['booking_success'];?></div>
        <?php
    
        unset($_SESSION['booking_success']);
    }
    }
    
    if (isset($_SESSION['booking_error'])) { // this is used to display failurte messages if the newsletter signup fails
        ?>
        <div class="failedtoast">
            <i class="fas fa-times-circle"></i> <?php echo $_SESSION['booking_error']; ?>
        </div>
        <?php
        unset($_SESSION['booking_error']);
    }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details <?php echo ($movie ? '- ' . htmlspecialchars($movie['FilmTitle']) : ''); ?></title>
    <link rel="stylesheet" href="css/juniorstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome icons -->
</head>
<body>



<nav class="navbar">
        <div class="container">
            <div class="logo">Limelight Cinema</div>
            
            <div class="nav-links">
                <a href="juniorindex.php">Home</a>
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





<div class="booking-wrapper">
    <div class="booking-container">
        <div class="booking-main-content">
            <div class="booking-movie-details">
                <div class="booking-movie-poster">
                    <img src="<?php echo $movie['poster_img']; ?>" alt="<?php echo htmlspecialchars($movie['FilmTitle']); ?> Poster">
                </div>
                <div class="booking-movie-info">
                    <h1><?php echo htmlspecialchars($movie['FilmTitle']); ?></h1>
                    <div class="booking-movie-meta">
                        <span class="booking-age-rating"><?php echo htmlspecialchars($movie['AgeRating']); ?></span>
                        <span class="booking-runtime"><?php echo $movie['Runtime']; ?> mins</span>
                        <span class="booking-genre"><?php echo htmlspecialchars($movie['Genres']); ?></span>
                    </div>
                    <p class="booking-description"><?php echo htmlspecialchars($movie['Filmdesc']); ?></p>
                    <div class="booking-cast">
                        <strong>Director:</strong> <?php echo htmlspecialchars($movie['Directors']); ?><br>
                        <strong>Cast:</strong> <?php echo htmlspecialchars($movie['Cast']); ?>
                    </div>
                </div>
            </div>

            <?php if (!empty($movie['Trailer'])): ?>
            <div class="booking-trailer-section">
                <h2 class="booking-trailer-title">Watch Trailer</h2>
                <div class="booking-trailer-container">
                    <iframe 
                        src="<?php echo htmlspecialchars($movie['Trailer']); ?>"
                        title="<?php echo htmlspecialchars($movie['FilmTitle']); ?> Trailer"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
            <?php endif; ?>
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