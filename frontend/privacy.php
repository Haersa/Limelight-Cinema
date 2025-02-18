<?php 
session_start();
include ('conn.php');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // these make sure the login feedback message on login is only displayed once, and isn't shown again if a user clicks the browser back arrow (found on stack overflow)
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(isset($_SESSION['login_message'])) {
{
    ?>
    <div class = "logintoast"> <?php echo $_SESSION['login_message'];?></div>
    <?php

    unset($_SESSION['login_message']);
}
}

if (isset($_SESSION['newsletter_fail'])) {
    ?>
    <div class="failedtoast">
        <i class="fas fa-times-circle"></i> <?php echo $_SESSION['newsletter_fail']; ?>
    </div>
    <?php
    unset($_SESSION['newsletter_fail']);
}

if(isset($_SESSION['newsletter_message'])) {
    {
        ?>
        <div class = "logintoast"> <?php echo $_SESSION['newsletter_message'];?></div>
        <?php
    
        unset($_SESSION['newsletter_message']);
    }
    }
    
    
    ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Limelight Cinema - Home</title>   
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

<div class="privacy-wrapper">
    <div class="privacy-hero">
        <h1>Privacy Policy</h1>
        <p>We're committed to protecting your privacy and ensuring your information is secure when using Limelight Cinema services.</p>
    </div>

    <div class="privacy-container">
        <div class="privacy-section">
            <h2><i class="fas fa-shield-alt"></i>Our Commitment</h2>
            <p>At Limelight Cinema, we prioritize the protection of your personal information. This policy explains how we collect, use, and safeguard your data when you use our website and cinema booking services.</p>
        </div>

        <div class="privacy-section">
            <h2><i class="fas fa-user-shield"></i>Information We Collect</h2>
            <div class="info-grid">
                <div class="info-card">
                    <i class="fas fa-user"></i>
                    <h4>Account Information</h4>
                    <p>Name, email address, and date of birth for account creation and management</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <h4>Cinema Preferences</h4>
                    <p>Your preferred cinema location and movie preferences</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-ticket-alt"></i>
                    <h4>Booking Details</h4>
                    <p>Movie selections, seat choices, and booking history</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-film"></i>
                    <h4>Movie Preferences</h4>
                    <p>Types of movies you're interested in for personalized recommendations</p>
                </div>
            </div>
        </div>

        <div class="privacy-section">
            <h2><i class="fas fa-cog"></i>How We Use Your Information</h2>
            <ul class="privacy-list">
                <li><i class="fas fa-ticket-alt"></i>Process your cinema bookings</li>
                <li><i class="fas fa-bell"></i>Send booking confirmations</li>
                <li><i class="fas fa-envelope"></i>Deliver newsletters (if subscribed)</li>
                <li><i class="fas fa-film"></i>Provide movie recommendations</li>
                <li><i class="fas fa-shield-alt"></i>Maintain account security</li>
                <li><i class="fas fa-chart-line"></i>Improve our services</li>
            </ul>
        </div>

        <div class="privacy-section">
            <h2><i class="fas fa-lock"></i>Data Security</h2>
            <div class="info-grid">
                <div class="info-card">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Secure Storage</h4>
                    <p>Data stored on protected servers in the UK with regular security audits</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-lock"></i>
                    <h4>Encryption</h4>
                    <p>256-bit SSL encryption for all data transfers</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-user-lock"></i>
                    <h4>Access Control</h4>
                    <p>Strict staff access controls and authentication</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-cloud"></i>
                    <h4>Regular Backups</h4>
                    <p>Automated backups to prevent data loss</p>
                </div>
            </div>
        </div>
        <div class="privacy-section">
            <h2><i class="fas fa-user-check"></i>Your Rights</h2>
            <div class="info-grid">
                <div class="info-card">
                    <i class="fas fa-eye"></i>
                    <h4>Access Rights</h4>
                    <p>Request a copy of all personal data we hold about you</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-edit"></i>
                    <h4>Correction Rights</h4>
                    <p>Update or correct any inaccurate personal information</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-trash"></i>
                    <h4>Deletion Rights</h4>
                    <p>Request deletion of your personal data</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-ban"></i>
                    <h4>Objection Rights</h4>
                    <p>Object to processing of your personal information</p>
                </div>
            </div>
        </div>

        <div class="privacy-section">
            <h2><i class="fas fa-clock"></i>Data Retention</h2>
            <div class="info-grid">
                <div class="info-card">
                    <i class="fas fa-user-clock"></i>
                    <h4>Active Accounts</h4>
                    <p>Data retained while your account remains active and in use</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-user-times"></i>
                    <h4>Account Deletion</h4>
                    <p>Data permanently removed within 30 days of deletion request</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-hourglass-end"></i>
                    <h4>Inactive Accounts</h4>
                    <p>Accounts inactive for 24+ months flagged for deletion</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-envelope"></i>
                    <h4>Notification</h4>
                    <p>Email notification before any account deletion</p>
                </div>
            </div>
        </div>

        <div class="contact-section">
            <h2><i class="fas fa-headset"></i> Contact Our Privacy Team</h2>
            <p>Have questions about your privacy or data? Our Data Protection team is here to help.</p>
            
            <div class="contact-details">
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>privacy@limelightcinema.com</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>0131 555 0000</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Limelight Cinema Head Office</span>
                    <span>123 Cinema Street</span>
                    <span>Edinburgh, EH1 1AA</span>
                </div>
            </div>
        </div>

        <p class="last-updated">Last updated: November 17, 2024</p>
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
                <li><a href="about.php">About Us</a></li>
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


</body>
</html>