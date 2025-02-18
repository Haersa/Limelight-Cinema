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

if (isset($_SESSION['newsletter_fail'])) { // this is used to display failurte messages if the newsletter signup fails
    ?>
    <div class="failedtoast">
        <i class="fas fa-times-circle"></i> <?php echo $_SESSION['newsletter_fail']; ?>
    </div>
    <?php
    unset($_SESSION['newsletter_fail']);
}

if(isset($_SESSION['newsletter_message'])) { // this is used to display success messages if newsletter signup is successful
    {
        ?>
        <div class = "logintoast"> <?php echo $_SESSION['newsletter_message'];?></div>
        <?php
    
        unset($_SESSION['newsletter_message']);
    }
    }
    
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta information -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <!-- Page title -->
    <title>Limelight Cinema - Home</title>   
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/style.css"> <!-- Main stylesheet -->
    <link rel="stylesheet" href="css/locationmodal.css"> <!-- Modal styling -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.3.0/flickity.min.css"> <!-- Flickity carousel styles -->
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
           <form method="POST" action="changecinema.php"> <!-- form to change users cinema location -->
               <button class="modal-accordion" type="button">Fort Kinnaird</button>
               <div class="modal-panel"> <!-- cinema options -->
                   <p>Fort Kinnaird Retail Park, Newcraighall Road</p>
                   <p>EH15 3RD</p>
                   <p>Tel: 0131 657 5555</p>
                   <p>Hours: Mon-Sun 10:00 - 23:00</p>
                   <button type="submit" name="cinema" value="Fort Kinnaird" class="modal-select-btn">Select This Location</button> <!-- button to select this cinema location -->
               </div>

               <button class="modal-accordion" type="button">Dalkeith</button>
               <div class="modal-panel"> <!-- cinema options -->
                   <p>Eskbank Road, Dalkeith</p> 
                   <p>EH22 3AU</p>
                   <p>Tel: 0131 663 1234</p>
                   <p>Hours: Mon-Sun 11:00 - 22:00</p>
                   <button type="submit" name="cinema" value="Dalkeith" class="modal-select-btn">Select This Location</button> <!-- button to select this cinema location -->
               </div>

               <button class="modal-accordion" type="button">Gorebridge</button>
               <div class="modal-panel"> <!-- cinema options -->
                   <p>Main Street, Gorebridge</p>
                   <p>EH23 4BY</p>
                   <p>Tel: 0131 445 6789</p>
                   <p>Hours: Mon-Sun 12:00 - 22:00</p>
                   <button type="submit" name="cinema" value="Gorebridge" class="modal-select-btn">Select This Location</button> <!-- button to select this cinema location -->
               </div>

               <button class="modal-accordion" type="button">Newtongrange</button>
               <div class="modal-panel"> <!-- cinema options -->
                   <p>Main Street, Newtongrange</p>
                   <p>EH22 4PU</p>
                   <p>Tel: 0131 445 9876</p>
                   <p>Hours: Mon-Sun 12:00 - 22:00</p>
                   <button type="submit" name="cinema" value="Newtongrange" class="modal-select-btn">Select This Location</button> <!-- button to select this cinema location -->
               </div>
           </form> <!-- end of form to change users cinema location -->
       </div>
   </div>
</div> <!-- end of location change modal -->

<nav class="navbar"> <!--start of navbar -->
    <div class="container"> <!-- start of navbar container -->
        <div class="logo">Limelight Cinema</div> <!-- logo title -->
        
        <div class="nav-links">
            <a href="index.php" class="nav-active">Home</a> <!--page links -->
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
    <a href="index.php" class="mobile-nav-active">Home</a> <!-- page links -->
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

<div class="hero-page-container"> 
  <!-- Container for the hero carousel -->
  <div class="hero-carousel-wrapper">
    <div class="hero-carousel">
      <!-- hero carousel starts -->
      <?php
      $query = "SELECT * FROM PromoMaterial ORDER BY RAND(1234) LIMIT 4"; // hero carousel query
      $result = mysqli_query($conn, $query);

      while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="hero-carousel-cell">
          <div 
            class="hero-slide-content" 
            style="
              background-image: url('<?php echo $row['image']; ?>'); 
              background-size: cover; 
              background-position: center;"
          >
            <div class="slide-text-content">
              <h2><?php echo htmlspecialchars($row['title']); ?></h2>
              <p><?php echo htmlspecialchars($row['description']); ?></p>
              <?php if ($row['promo_movie'] === 'yes'): ?>
                <a href="movies.php" class="button-link">
                  <button class="promo-slide-button promo-book-button">Book Tickets</button>
                </a>
              <?php else: ?>
                <a href="specialoffers.php" class="button-link">
                  <button class="promo-slide-button promo-info-button">View Offers</button>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
      <!-- end of hero carousel  -->
    </div>
    <div class="hero-navigation-buttons"> <!-- start of hero carousel navigation buttons -->
      <button class="hero-nav-button prev-button">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button class="hero-nav-button next-button">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
    <!-- end of hero navigation buttons -->
  </div>
  <!-- end of hero-carousel-wrapper -->
</div>
<!-- end of Container for the hero carousel -->

<div class="top-films-container">
   <div class="top-films-header">
       <h2>Top Films</h2>
   </div>
   <div class="top-films-carousel-wrapper">
       <div class="films-flickity-carousel">
           <?php
           $query = "SELECT * FROM LimelightFilms WHERE Coming_Soon = 'no' LIMIT 30";
           $result = mysqli_query($conn, $query);
           
           while($row = mysqli_fetch_assoc($result)) {
               ?>
               <div class="film-carousel-cell">
                   <div class="film-card">
                       <a href="movies.php">
                           <img class="card-front-image card-image" src="<?php echo $row['thumbnail_img']; ?>" alt="<?php echo htmlspecialchars($row['FilmTitle']); ?>">
                       </a>
                       <div class="card-faders">
                           <?php for($i = 0; $i < 8; $i++) { ?>
                               <img class="card-fader card-image" src="<?php echo $row['thumbnail_img']; ?>" alt="">
                           <?php } ?>
                       </div>
                   </div>
               </div>
               <?php
           }
           ?>
       </div>
       <div class="films-navigation-buttons">
           <button class="films-nav-button prev-button">
               <i class="fas fa-chevron-left"></i>
           </button>
           <button class="films-nav-button next-button">
               <i class="fas fa-chevron-right"></i>
           </button>
       </div>
   </div>
</div>



<!-- Movie Spotlight Section -->
<div class="movie-spotlight">
    <div class="spotlight-content">
        <h2>Gladiator 2</h2>
        <p>Gladiator 2 is here! Experience the epic return to Rome’s arenas. Book your tickets now and witness the action on the big screen.</p>
        <?php if (isset($_SESSION['logged_in'])): ?>
        <a href="movies.php" class="book-link">Book</a>
        <?php endif; ?>
    </div>
    <div class="spotlight-image">
        <img src="images/gladiator2.PNG" alt="Gladiator 2 Movie Image">
    </div>
</div><!--end of spotlight section-->

<div class="index-special-offers-teaser"> <!-- special offers section -->
        <div class="index-container">
            <div class="index-teaser-content">
                <h2 class="index-teaser-heading">Exclusive Offers Await!</h2>
                <p class="index-teaser-description">
                    Discover amazing deals and exclusive discounts on our latest collection. 
                    Our special offers page is regularly updated with new savings opportunities you won't want to miss.
                </p>
                
                <div class="index-highlight-points">
                    <div class="index-highlight-point">Exclusive Member Discounts</div>
                    <div class="index-highlight-point">Limited-Time Deals</div>
                    <div class="index-highlight-point">Seasonal Promotions</div>
                </div>

                <a href="specialoffers.php" class="index-cta-button">View Special Offers</a> <!--link to special offers paage-->
                
                <div class="index-teaser-footer">
                    *New offers added weekly. Terms and conditions apply*
                </div>
            </div>
        </div>
    </div> <!-- end of special offers section -->




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
<script src="js/script.js"></script>
<script src="js/sliders.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.2.2/flickity.pkgd.min.js"></script>

</body>
</html>