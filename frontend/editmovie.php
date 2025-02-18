<?php
session_start();
include('conn.php');

// Get the movie details based on ID 
if(isset($_GET['id'])) {
    $filmId = $_GET['id'];
    $query = "SELECT * FROM LimelightFilms WHERE FilmID = '$filmId'";
    $result = mysqli_query($conn, $query);
    $movie = mysqli_fetch_assoc($result);
}
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie - <?php echo htmlspecialchars($movie['FilmTitle']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/adminstyle.css">
</head>
<body>
<?php
if (!isset($_SESSION["admin_logged_in"])) {
    echo "<div class='edit-alert-container'>
            <div class='edit-alert'>
                <i class='fas fa-exclamation-triangle edit-warning-icon'></i>
                <h1>You don't have permission to view this page!</h1>
                <p>Please log in with admin credentials to access this area.</p>
            </div>
            <form action='logout.php' method='POST'>
                <input type='hidden' name='redirect' value='index.php'>
                <button type='submit' class='edit-back-to-home'>Back to Home</button>
            </form>
          </div>";
} else {
?>

<div class="edit-container">
    <div class="edit-header">
        <h1 class="edit-title">Edit Movie - <?php echo htmlspecialchars($movie['FilmTitle']); ?></h1>
        <div class="edit-nav-buttons">
            <a href='moviecrud.php' class="edit-back-btn">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href='adminlogout.php' class="edit-logout-btn">
                <i class="fas fa-sign-out-alt"></i> Sign out
            </a>
        </div>
    </div>
    <div class="edit-poster-section">
    <h2 class="edit-section-title">Current Movie Poster</h2>
    <div class="edit-poster-wrapper">
        <img src="<?php echo htmlspecialchars($movie['poster_img']); ?>" 
             alt="Movie Poster" 
             class="edit-poster-preview">
    </div>
</div>

    <form action="updatemovie.php" method="POST" enctype="multipart/form-data">
        <div class="edit-content">
            <div class="edit-image-section">
                <div class="edit-image-preview">
                    <h3 class="edit-preview-title">Current Thumbnail</h3>
                    <img src="<?php echo htmlspecialchars($movie['thumbnail_img']); ?>" 
                         alt="Movie Thumbnail" 
                         class="edit-current-image">
                </div>
            </div>

            <!--Form Fields -->
            <div class="edit-form-section">
                <div class="edit-form-group">
                    <label class="edit-label">Title</label>
                    <input type="text" class="edit-input" name="title" 
                           value="<?php echo htmlspecialchars($movie['FilmTitle']); ?>" required>
                </div>

                <div class="edit-form-group">
                    <label class="edit-label">Description</label>
                    <textarea class="edit-textarea" name="description" 
                              required><?php echo htmlspecialchars($movie['Filmdesc']); ?></textarea>
                </div>

                <div class="edit-form-group">
                    <label class="edit-label">Runtime (minutes)</label>
                    <input type="number" class="edit-input" name="runtime" 
                           value="<?php echo htmlspecialchars($movie['Runtime']); ?>" required>
                </div>

                <div class="edit-form-group">
                    <label class="edit-label">Age Rating</label>
                    <select class="edit-select" name="age_rating" required>
                        <option value="U" <?php echo $movie['AgeRating'] == 'U' ? 'selected' : ''; ?>>U - Universal</option>
                        <option value="PG" <?php echo $movie['AgeRating'] == 'PG' ? 'selected' : ''; ?>>PG - Parental Guidance</option>
                        <option value="12A" <?php echo $movie['AgeRating'] == '12A' ? 'selected' : ''; ?>>12A - Under 12s with adult</option>
                        <option value="12" <?php echo $movie['AgeRating'] == '12' ? 'selected' : ''; ?>>12 - Suitable for 12 and over</option>
                        <option value="15" <?php echo $movie['AgeRating'] == '15' ? 'selected' : ''; ?>>15 - Suitable for 15 and over</option>
                        <option value="18" <?php echo $movie['AgeRating'] == '18' ? 'selected' : ''; ?>>18 - Adults only</option>
                    </select>
                </div>

                <div class="edit-form-group">
                    <label class="edit-label">Director(s)</label>
                    <input type="text" class="edit-input" name="directors" 
                           value="<?php echo htmlspecialchars($movie['Directors']); ?>" required>
                </div>

                <div class="edit-form-group">
                    <label class="edit-label">Status</label>
                    <select class="edit-select" name="coming_soon" required>
                        <option value="No" <?php echo $movie['Coming_Soon'] == 'No' ? 'selected' : ''; ?>>Now Showing</option>
                        <option value="Yes" <?php echo $movie['Coming_Soon'] == 'Yes' ? 'selected' : ''; ?>>Coming Soon</option>
                    </select>
                </div>

                <div class="edit-form-group">
                    <label class="edit-label">Genres</label>
                    <input type="text" class="edit-input" name="genres" 
                           value="<?php echo htmlspecialchars($movie['Genres']); ?>" required>
                </div>

                <div class="edit-form-group">
                    <label class="edit-label">Cast</label>
                    <input type="text" class="edit-input" name="cast" 
                           value="<?php echo htmlspecialchars($movie['Cast']); ?>" required>
                </div>

                <div class="edit-form-group">
                    <label class="edit-label">Supporting Cast</label>
                    <input type="text" class="edit-input" name="supporting_cast" 
                           value="<?php echo htmlspecialchars($movie['SupportingCast']); ?>" required>
                </div>

                <div class="edit-form-group">
                    <label class="edit-label">Movie Rating</label>
                    <input type="number" class="edit-input" name="movie_rating" 
                           step="0.1" min="0" max="5" 
                           value="<?php echo htmlspecialchars($movie['MovieRating']); ?>" required>
                </div>

                <div class="edit-form-group">
                    <label class="edit-label">Trailer (YouTube Embed URL)</label>
                    <input type="url" class="edit-input" name="trailer" 
                        value="<?php echo htmlspecialchars($movie['Trailer']); ?>" 
                        placeholder="https://www.youtube.com/embed/...">
                </div>


                <div class="edit-form-group">
                    <label class="edit-label">Update Thumbnail</label>
                    <input type="file" name="thumbnail_image" accept="image/*" class="edit-file-input">
                </div>

                <div class="edit-form-group">
                    <label class="edit-label">Update Poster</label>
                    <input type="file" name="poster_image" accept="image/*" class="edit-file-input">
                </div>
            </div>
        </div>

        <input type="hidden" name="film_id" value="<?php echo $filmId; ?>">
        
        <div class="edit-actions">
            <button type="submit" name="update" class="edit-update-btn">Update Movie</button>
            <a href="moviecrud.php" class="edit-delete-btn">Cancel</a>
        </div>
    </form>
</div>

<?php
}
?>
<script src="js/adminpanel.js"></script>
</body>
</html>