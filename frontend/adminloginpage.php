<?php 
session_start(); 
include('conn.php');  

// Only show error message if it exists
if (isset($_SESSION['login_fail'])) {
?>     
    <div class="failedtoast">         
        <i class="fas fa-times-circle"></i> <?php echo $_SESSION['login_fail']; ?>     
    </div> 
<?php     
    unset($_SESSION['login_fail']); // Clear the message after showing it
} 
?>  

<!DOCTYPE html> 
<html lang="en"> 
<head>     
    <meta charset="UTF-8">     
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">     
    <title>Administrator Log-in</title>     
    <link rel="stylesheet" href="css/style.css">     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
</head> 
<body>     

<nav class="navbar">
    <div class="container">
        <div class="logo">Limelight Cinema</div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="movies.php">Movies</a>
            <a href="cinemas.php">Cinemas</a>
            <a href="comingsoon.php">Coming Soon</a>
            <a href="about.php">About Us</a>
        </div>
        <div class="nav-group">
            <button class="menu-toggle">☰</button>
        </div>
    </div>
</nav>

<div class="mobile-menu">
    <button class="close-menu">×</button>
    <div class="mobile-header">
        <div class="logo">Limelight Cinema</div>
    </div>
    
    <nav class="mobile-nav">
        <a href="index.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="cinemas.php">Cinemas</a>
        <a href="comingsoon.php">Coming Soon</a>
        <a href="about.php">About Us</a>
    </nav>  
    
    <div class="social-icons">
    <a href="https://www.facebook.com/" class="social-icon"><i class="fab fa-facebook-f"></i></a>
    <a href="https://www.linkedin.com/" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
    <a href="https://www.instagram.com/" class="social-icon"><i class="fab fa-instagram"></i></a>
    <a href="https://www.tiktok.com/en/" class="social-icon"><i class="fa-brands fa-tiktok"></i></a>
    </div>
    
</div>


<main>
    <div class="admin-login-container">
        <form class="admin-login-form" action="adminlogin.php" method="POST" novalidate>
            <h2 class="admin-login-title">Admin Sign in</h2>
            <p class="admin-login-subtitle">Admin Access Only.</p>
            
            <div class="admin-login-form-group">
                <div class="admin-login-input-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <input type="text" id="username" name="username" class="admin-login-input" placeholder="Admin Username" required>
            </div>

            <div class="admin-login-form-group">
                <div class="admin-login-input-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <input type="password" id="password" name="password" class="admin-login-input" placeholder="Admin Password" required>
            </div>

            <div class="admin-login-form-group">
                <div class="admin-login-input-icon">
                    <i class="fas fa-key"></i>
                </div>
                <input type="password" id="passkey" name="passkey" class="admin-login-input" placeholder="Admin Passkey" required>
            </div>

            <button type="submit" class="admin-login-button">
                 Sign in 
            </button>

            <div class="admin-login-footer">
                <a href="index.php" class="admin-return-link">
                     Return to User Area
                </a>
            </div>
        </form>
    </div>
</main> 
    
    

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
                <a href="https://www.facebook.com/" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.linkedin.com/" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://www.instagram.com/" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="https://www.tiktok.com/en/" class="social-icon"><i class="fa-brands fa-tiktok"></i></a>
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

    <script src="js/script.js"></script> 
</body> 
</html>
