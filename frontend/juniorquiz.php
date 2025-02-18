<?php 
session_start();
include ('conn.php');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // these make sure the login feedback message on login is only displayed once, and isn't shown again if a user clicks the browser back arrow (found on stack overflow)
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Junior Quiz</title>
    <link rel="stylesheet" href="css/juniorstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<nav class="navbar"><!-- junior navbar -->
        <div class="container">
            <div class="logo">Limelight Cinema</div>
            
            <div class="nav-links">
                <a href="juniorindex.php">Home</a>
                <a href="juniormovies.php">Movies</a>
                <a href="juniorquiz.php"  class="nav-active">Quiz</a>
            </div>
            
            <div class="nav-group">
                <?php if (isset($_SESSION['junior_login'])): ?>
                    <a href="juniorlogout.php" class="logout-btn">Sign out </a>
                <?php endif; ?>
                <button class="menu-toggle">☰</button>
            </div>
        </div>
    </nav><!-- enf of junior navbar -->

    <div class="quiz-container">
        <div class="quiz-card" id="quiz-container">
            <!-- Quiz content will be dynamically inserted here -->
        </div>
    </div>


    <div class="sections-container">
        <!-- Top Scores Section -->
        <div class="section">
            <h2 class="section-title">Top Scores</h2>
            <div class="score-list">
                <div class="score-item">
                    <span class="player-name">MovieMaster</span>
                    <span class="score">95%</span>
                </div>
                <div class="score-item">
                    <span class="player-name">FilmFanatic</span>
                    <span class="score">90%</span>
                </div>
                <div class="score-item">
                    <span class="player-name">CinemaGuru</span>
                    <span class="score">85%</span>
                </div>
            </div>
        </div>

        <!-- Quick Tips Section -->
        <div class="section">
            <h2 class="section-title">Quick Tips</h2>
            <div class="tips-list">
                <div class="tip-item">
                    <span class="tip-bullet">•</span>
                    <span class="tip-text">Watch all movie's trailer before taking the quiz to refresh your memory</span>
                </div>
                <div class="tip-item">
                    <span class="tip-bullet">•</span>
                    <span class="tip-text">Pay close attention to main character names and their relationships</span>
                </div>
                <div class="tip-item">
                    <span class="tip-bullet">•</span>
                    <span class="tip-text">Remember key scenes and plot twists from the movie</span>
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