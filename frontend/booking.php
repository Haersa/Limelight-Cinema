<?php
session_start();
include('conn.php');


// Get user info to check member type
$user_id = $_SESSION['user_id'];
$userQuery = "SELECT member_type, preferred_cinema FROM LimelightMembers WHERE ID = '$user_id'";
$userResult = mysqli_query($conn, $userQuery);
$userInfo = mysqli_fetch_assoc($userResult);

// Restrict access for junior/admin members as a precaution, even though junior members wont be able to see 'book' button
if($userInfo['member_type'] == 'junior' || $userInfo['member_type'] == 'admin') {
    $_SESSION['booking_error'] = "This account type cannot book tickets";
    header("Location: movies.php");
    exit();
}

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
    <title>Book Tickets <?php echo ($movie ? '- ' . htmlspecialchars($movie['FilmTitle']) : ''); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/locationmodal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<!-- location change modal -->
<div id="modal-location" class="modal-location">
   <div class="modal-location-content">
       <div class="modal-location-header">
           <h2>Select Your Cinema</h2>
           <button class="modal-location-close">&times;</button>
       </div>
       <div class="modal-location-body">
           <form method="POST" action="changecinema.php">
               <button class="modal-accordion" type="button">Fort Kinnaird</button>
               <div class="modal-panel">
                   <p>Fort Kinnaird Retail Park, Newcraighall Road</p>
                   <p>EH15 3RD</p>
                   <p>Tel: 0131 657 5555</p>
                   <p>Hours: Mon-Sun 10:00 - 23:00</p>
                   <button type="submit" name="cinema" value="Fort Kinnaird" class="modal-select-btn">Select This Location</button>
               </div>

               <button class="modal-accordion" type="button">Dalkeith</button>
               <div class="modal-panel">
                   <p>Eskbank Road, Dalkeith</p>
                   <p>EH22 3AU</p>
                   <p>Tel: 0131 663 1234</p>
                   <p>Hours: Mon-Sun 11:00 - 22:00</p>
                   <button type="submit" name="cinema" value="Dalkeith" class="modal-select-btn">Select This Location</button>
               </div>

               <button class="modal-accordion" type="button">Gorebridge</button>
               <div class="modal-panel">
                   <p>Main Street, Gorebridge</p>
                   <p>EH23 4BY</p>
                   <p>Tel: 0131 445 6789</p>
                   <p>Hours: Mon-Sun 12:00 - 22:00</p>
                   <button type="submit" name="cinema" value="Gorebridge" class="modal-select-btn">Select This Location</button>
               </div>

               <button class="modal-accordion" type="button">Newtongrange</button>
               <div class="modal-panel">
                   <p>Main Street, Newtongrange</p>
                   <p>EH22 4PU</p>
                   <p>Tel: 0131 445 9876</p>
                   <p>Hours: Mon-Sun 12:00 - 22:00</p>
                   <button type="submit" name="cinema" value="Newtongrange" class="modal-select-btn">Select This Location</button>
               </div>
           </form>
       </div>
   </div>
</div>

<nav class="navbar"> <!--start of navbar -->
    <div class="container"> <!-- start of navbar container -->
        <div class="logo">Limelight Cinema</div> <!-- logo title -->
        
        <div class="nav-links">
            <a href="index.php">Home</a> <!--page links -->
            <a href="movies.php">Movies</a> <!--page links -->
            <a href="cinemas.php">Cinemas</a> <!--page links -->
            <a href="comingsoon.php">Coming Soon</a> <!--page links -->
            <a href="specialoffers.php">Special Offers</a> <!--page links -->
        </div>
        
        <div class="nav-group">
            <?php if (!isset($_SESSION['logged_in'])): ?> <!-- if user isnt logged in, show this block of code -->
                <div class="auth-buttons"> 
                    <a href="loginpage.php" class="btn login-btn">Sign in</a> <!--page links -->
                    <a href="registerpage.php" class="btn register-btn">Register</a> <!--page links -->
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['logged_in'])): ?> <!-- if user is logged in, show this block of code -->
                <div class="profile-dropdown"> <!-- profile dropdown menu starts  -->
                    <button class="profile-toggle" aria-expanded="false" aria-controls="profileDropdown"> <!-- button to open profile dropdown menu -->
                        <i class="fa-regular fa-circle-user fa-lg"></i> <!-- profile icon -->
                        <span class="sr-only">Profile Menu</span>
                    </button>
                    <div id="profileDropdown" class="dropdown-content">
                        <a href="profile.php"> <i class="fas fa-user"></i> Profile</a> <!--page links -->
                        <a href = "tickets.php"> <i class="fas fa-ticket-alt"></i> My Tickets</a> <!--page links -->
                        <a href = "settings.php"> <i class="fa-solid fa-gear"></i> Settings</a> <!--page links -->
                        <a href="logout.php"> Sign out <i class="fa-solid fa-arrow-right-from-bracket"></i> </a> <!--logout button -->
                    </div>
                </div>

                <div class="desktop-preferred-cinema"> <!--desktop-preferred-cinema-->
                    <button class="location-toggle" aria-expanded="false" aria-controls="location-modal"> <!-- open modal to allow user to change their preferred cinema location -->
                        <i class="fas fa-location-dot"></i>
                        <?php 
                        if (isset($_SESSION['logged_in'])) { // if user is logged in, show their preferred cinema based on the user id session that is active
                            $user_id = $_SESSION['user_id'];
                            $query = mysqli_query($conn, "SELECT preferred_cinema FROM LimelightMembers WHERE ID = '$user_id'"); // sql query to get the preferred cinema from the database
                            $result = mysqli_fetch_array($query);
                            if($result) {
                                echo "<span>" . $result['preferred_cinema'] . "</span>"; // show preferred cinema
                            } else {
                                echo "<span>No cinema selected</span>"; // error message
                            }
                        }
                        ?>
                        <i class="fas fa-chevron-down"></i> <!-- down arrow icon next to profile icon to hint its clickable -->
                    </button>
                </div>
            <?php endif; ?>
            
            <button class="menu-toggle">☰</button> <!--mobile menu button/toggler -->
        </div>
    </div> <!-- end of navbar container -->
</nav> <!-- end of navbar -->

<div class="mobile-menu"> <!-- start of mobile menu -->
    <button class="close-menu">×</button> <!-- close menu button -->
    <div class="mobile-header"> <!-- mobile menu header -->
        <div class="logo">Limelight Cinema</div> <!-- logo/title -->
    </div>
    
<nav class="mobile-nav"> <!-- start of mobile menu navigation -->
    <a href="index.php">Home</a> <!-- page links -->
    <a href="movies.php">Movies</a> <!-- page links -->
    <a href="cinemas.php">Cinemas</a> <!-- page links -->
    <a href="comingsoon.php">Coming Soon</a> <!-- page links -->
    <a href="specialoffers.php">Special Offers</a> <!-- page links -->
</nav> <!-- end of mobile menu navigation -->

<?php if (!isset($_SESSION['logged_in'])): ?>  <!-- if user isnt logged in, show this block of code -->
    <div class="mobile-auth-buttons">
        <a href="loginpage.php" class="login-btn">Sign in</a> <!-- page links -->
        <a href="registerpage.php" class="register-btn">Register</a> <!-- page links --> 
    </div>
<?php endif; ?>
    <?php if (isset($_SESSION['logged_in'])): ?> <!-- if user is logged in, show this block of code -->
        <div class="user-actions">
            <a href="tickets.php" class="action-button">
                <i class="fas fa-ticket-alt"></i> My Tickets <!-- page links -->
            </a>
            <a href="profile.php" class="action-button">
                <i class="fas fa-user"></i> Profile <!-- page links -->
            </a>
            <a href="settings.php" class="action-button">
                <i class="fa-solid fa-gear"></i> Settings <!-- page links -->
            </a>
        </div>

        <div class="mobile-preferred-cinema-section"> <!--mobile preferred cinema -->
    <h3 class="mobile-preferred-cinema-header">Your Preferred Cinema</h3>
    <div class="mobile-cinema-display">
        <i class="fas fa-location-dot"></i>
        <span class="cinema-name">
            <?php   
            if (isset($_SESSION['logged_in'])) {
                $user_id = $_SESSION['user_id'];
                $query = mysqli_query($conn, "SELECT preferred_cinema FROM LimelightMembers WHERE ID = '$user_id'"); // sql query to get the preferred cinema from the database
                $result = mysqli_fetch_array($query);
                if($result) {
                    echo $result['preferred_cinema']; // show preferred cinema
                } else {
                    echo "No cinema selected";
                }
            }
            ?>
        </span>
    </div>
    <button class="change-cinema-link" aria-expanded="false"> <!-- button to allow users to change their preferred cinema -->
        <span>Change Cinema?</span>
        <i class="fas fa-chevron-right"></i> <!-- downward arrow to hint to user it is clickable -->
    </button>
    <form method="POST" action="changecinema.php" class="mobile-cinema-options"> <!-- form to capture user input for changing preferred cinema -->
        <button type="submit" name="cinema" value="Fort Kinnaird">Fort Kinnaird</button> <!-- cinema locations -->
        <button type="submit" name="cinema" value="Dalkeith">Dalkeith</button> <!-- cinema locations -->
        <button type="submit" name="cinema" value="Gorebridge">Gorebridge</button> <!-- cinema locations -->
        <button type="submit" name="cinema" value="Newtongrange">Newtongrange</button> <!-- cinema locations -->
    </form> <!-- end of form -->
</div>
    <?php endif; ?>
    
    <div class="social-icons"> <!-- social media links -->
        <a href="https://www.facebook.com/" target = "_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a> <!-- social media icons -->
        <a href="https://www.linkedin.com/" target = "_blank" class="social-icon"><i class="fab fa-linkedin-in"></i></a> <!-- social media icons -->
        <a href="https://www.instagram.com/" target = "_blank" class="social-icon"><i class="fab fa-instagram"></i></a> <!-- social media icons -->
        <a href="https://www.tiktok.com/en/" target = "_blank" class="social-icon"><i class="fa-brands fa-tiktok"></i></a> <!-- social media icons -->
    </div>
    
    <?php if (isset($_SESSION['logged_in'])): ?>
        <div class="logout-container">
            <a href="logout.php" class="logout-button">
                <i class="fas fa-sign-out-alt"></i>Sign out <!-- logout button -->
            </a>
        </div>
    <?php endif; ?>
</div> <!-- end of mobile menu -->

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

        <div class="booking-form">
            <form action="processbooking.php" method="POST">
                <input type="hidden" name="film_id" value="<?php echo $filmId; ?>">
                
                <div class="booking-form-group">
                    <label>Number of Tickets:</label>
                    <input type="number" name="number_of_seats" min="1" max="4" required placeholder = "Ticket Quantity:">
                </div>
                
                <div class="booking-form-group">
                    <label>Select Date and Time:</label>
                    <select name="showtime" required>
                        <?php
                        while($showtime = mysqli_fetch_assoc($showtimesResult)) {
                            $dateTime = date('M d, Y - g:i A', strtotime($showtime['ShowDate'] . ' ' . $showtime['ShowTime']));
                            echo "<option value='" . $showtime['ShowDate'] . " " . $showtime['ShowTime'] . "'>" . $dateTime . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" name="book_tickets" class="booking-submit-btn">Book Now</button>
            </form>
        </div>
    </div>
</div>



<div class="footer">
    <div class="footer-content">
        <!-- Logo Section -->
        <div class="footer-logo-section">
            <div class="placeholder-logo">
                <div class="logo-squares">
                    <div class="square"></div>
                    <div class="square"></div>
                </div>
            </div>
            <p class="footer-tagline">The Go-to Cinema for Midlothian.</p>
        </div>

        <!-- Site Map Section -->
        <div class="footer-section">
            <h3>Site Map</h3>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="movies.php">Movies</a></li>
                <li><a href="cinemas.php">Cinemas</a></li>
                <li><a href="comingsoon.php">Coming Soon</a></li>
                <li><a href="specialoffers.php">Special Offers</a></li>
            </ul>
        </div>

        <!-- Social Section -->
        <div class="footer-section">
            <h3>Connect</h3>
            <div class="social-icons">
                <a href="https://www.facebook.com/" target = "_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.linkedin.com/" target = "_blank" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://www.instagram.com/" target = "_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="https://www.tiktok.com/en/" target = "_blank" class="social-icon"><i class="fa-brands fa-tiktok"></i></a>
            </div>
            <div class="footer-contact">
                <a href="contact.php">Contact Us <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="footer-newsletter">
        <div class="newsletter-content">
            <h2 class="footer-heading">Subscribe to Our Newsletter</h2>
            <form class="footer-form" method="POST" action="newsletter.php">
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="submit" class="footer-button" value="Subscribe">
            </form>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div class="footer-bottom-content">
            <p>&copy; 2024 Limelight Cinema. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="adminloginpage.php">Admin Login</a>
                <a href="privacy.php">Privacy Policy</a>
            </div>
        </div>
    </div>
</div>
</div>

</div>


<script src = "js/booking.js"></script>
</body>
</html>