<?php
session_start();
include('conn.php');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // these make sure the login feedback message on login is only displayed once, and isn't shown again if a user clicks the browser back arrow (found on stack overflow)
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


// Display update messages
if(isset($_SESSION['movie_success'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['movie_success'] . '</div>';
    unset($_SESSION['movie_success']);
}
if(isset($_SESSION['movie_fail'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['movie_fail'] . '</div>';
    unset($_SESSION['movie_fail']);
}

// Display delete messages
if(isset($_SESSION['delete_success'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['delete_success'] . '</div>';
    unset($_SESSION['delete_success']);
}
if(isset($_SESSION['delete_fail'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['delete_fail'] . '</div>';
    unset($_SESSION['delete_fail']);
}


if(isset($_SESSION['showtime_success'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['showtime_success'] . '</div>';
    unset($_SESSION['showtime_success']);
}
if(isset($_SESSION['showtime_fail'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['showtime_fail'] . '</div>';
    unset($_SESSION['showtime_fail']);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Movie Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/adminstyle.css">
</head>
<body>
<?php
if (!isset($_SESSION["admin_logged_in"])) {
    echo "<div class='alert-container'>
            <div class='AdminAlert'>
                <i class='fas fa-exclamation-triangle warning-icon'></i>
                <h1>You don't have permission to view this page!</h1>
                <p>Please log in with admin credentials to access this area.</p>
            </div>
            <form action='adminlogout.php' method='POST'>
                <input type='hidden' name='redirect' value='index.php'>
                <button type='submit' class='back-to-home'>Back to Home</button>
            </form>
          </div>";
} else {
    ?>
    <nav class="navbar">
        <ul class="navbar-nav">
            <li class="logo">
                <a class="nav-link">
                    <span class="link-text logo-text">Admin Panel</span>
                    <i class="fas fa-angle-double-right"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="adminpanel.php" class="nav-link">
                    <i class="fas fa-home fa-2x"></i>
                    <span class="link-text">Admin Panel</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="membercrud.php" class="nav-link">
                    <i class="fas fa-user-edit fa-2x"></i>
                    <span class="link-text">Member Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="fileuploader.php" class="nav-link">
                    <i class="fas fa-plus-circle fa-2x"></i>
                    <span class="link-text">Add a Movie</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="moviecrud.php" class="nav-link active">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span class="link-text">Movie Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="adminprocessing.php" class="nav-link">
                    <i class="fa-solid fa-user-tie"></i>
                    <span class="link-text">Manage Admins</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="promotionalmaterial.php" class="nav-link">
                    <i class="fa-solid fa-newspaper"></i>
                    <span class="link-text">Promotional Material</span>
                </a>
            </li>
            <li class="nav-item" id="logout">
                <a href="adminlogout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt fa-2x"></i>
                    <span class="link-text">Sign out</span>
                </a>
            </li>
        </ul>
    </nav>

<div class = "admin-content">
<div class="movie-container">
    <h1 class="movie-header">Movie Management</h1>
    
    <div class="movie-list">
        <?php
        $query = "SELECT FilmID, FilmTitle, Filmdesc, thumbnail_img, Runtime, 
        Directors, Genres, Coming_Soon, AgeRating, Cast, 
        SupportingCast, MovieRating, Trailer 
 FROM LimelightFilms 
 ORDER BY FilmID DESC";

        $result = mysqli_query($conn, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            while ($movie = mysqli_fetch_assoc($result)) {
                ?>
                <div class="movie-item">
                    <div class="movie-thumbnail">
                        <img src="<?php echo htmlspecialchars($movie['thumbnail_img']); ?>" 
                             alt="<?php echo htmlspecialchars($movie['FilmTitle']); ?>">
                    </div>
                    
                    <div class="movie-info">
                        <h2 class="movie-title"><?php echo htmlspecialchars($movie['FilmTitle']); ?></h2>
                        <p class="movie-details">Runtime: <?php echo htmlspecialchars($movie['Runtime']); ?> minutes</p>
                        <p class="movie-details">Director: <?php echo htmlspecialchars($movie['Directors']); ?></p>
                        <p class="movie-details">Genres: <?php echo htmlspecialchars($movie['Genres']); ?></p>
                        <p class="movie-details">Age Rating: <?php echo htmlspecialchars($movie['AgeRating']); ?></p>
                        <p class="movie-details">Status: <?php echo $movie['Coming_Soon'] == 'Yes' ? 'Coming Soon' : 'Now Showing'; ?></p>
                        <p class="movie-details">Rating: <?php echo $movie['MovieRating']; ?>/5</p>
                    </div>
                    
                    <div class="movie-actions">
                        <a href="editmovie.php?id=<?php echo $movie['FilmID']; ?>" class="movie-update-btn">Update</a>
                        <a href="deletemovie.php?id=<?php echo $movie['FilmID']; ?>" class="movie-delete-btn" onclick="return confirm('Are you sure you want to delete this movie?');">Delete</a>
                            <a href="generateshowtimes.php?id=<?php echo $movie['FilmID']; ?>" class="movie-generate-btn">Generate Showtimes</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No movies found in the database.</p>";
        }
        ?>
    </div>
</div>
</div>







    <?php
}
?>

<script src="js/adminpanel.js"></script>
</body>
</html>