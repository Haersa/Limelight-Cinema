<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Movie</title>
    <link rel="stylesheet" href="css/movieuploader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php
session_start();
include "conn.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // these make sure the login feedback message on login is only displayed once, and isn't shown again if a user clicks the browser back arrow (found on stack overflow)
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (isset($_SESSION["upload_success"])) {
    echo '<div class="successtoast">' . $_SESSION["upload_success"] . "</div>";
    unset($_SESSION["upload_success"]);
}

if (isset($_SESSION["upload_fail"])) {
    echo '<div class="failedtoast"><i class="fas fa-times-circle"></i> ' .
        $_SESSION["upload_fail"] .
        "</div>";
    unset($_SESSION["upload_fail"]);
}

if (!isset($_SESSION["admin_logged_in"])) {
    echo "<div class='alert-container'>
            <div class='AdminAlert'>
                <i class='fas fa-exclamation-triangle warning-icon'></i>
                <h1>You don't have permission to view this page!</h1>
                <p>Please log in with administrator credentials to access this area.</p>
            </div>
            <form action='logout.php' method='POST'>
                <input type='hidden' name='redirect' value='index.php'>
                <button type='submit' class='back-to-home'>Back to Home</button>
            </form>
          </div>";
} else {
     ?>
    <div class="uploadwrapper">
        <h1 class="page-title">Add a Movie</h1>
        <div class="nav-buttons">
            <a href='adminpanel.php' class="back-btn"><i class="fas fa-arrow-left"></i> Back to Admin Panel</a>
            <a href='adminlogout.php' class="logout-btn"><i class="fas fa-sign-out-alt"></i> Sign out</a>
        </div>
        <div class='uploadcard'>
            <form class="uploadform" action="upload.php" method="POST" enctype="multipart/form-data">
                <p class="filedisclaimer">Disclaimer: Only Image File Formats are accepted.</p>
                
                <label for="thumbnail_image">Thumbnail Image (for cards):</label>
                <input type="file" name="thumbnail_image" id="thumbnail_image" accept="image/*" required>
                
                <label for="poster_image">Poster Image (landscape):</label>
                <input type="file" name="poster_image" id="poster_image" accept="image/*" required>
                
                <input type="text" name="title" placeholder="Movie Title" required>
                
                <textarea name="description" placeholder="Movie Description" required></textarea>
                
                <input type="number" name="runtime" placeholder="Runtime (in minutes)" required>
                
                <input type="text" name="cast" placeholder="Cast (comma-separated)" required>
                
                <input type="text" name="supporting_cast" placeholder="Supporting Cast (comma-separated)" required>
                
                <input type="text" name="directors" placeholder="Director(s) (comma-separated)" required>
                
                <input type="text" name="genres" placeholder="Genres (comma-separated)" required>

                <input type = "text" name = "trailer" placeholder="Trailer url here" required>
                
                <select name="coming_soon" required>
                    <option value="">Coming Soon?</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                
                <select name="age_rating" required>
                    <option value="">Select Age Rating</option>
                    <option value="U">U </option>
                    <option value="PG">PG </option>
                    <option value="12A">12A </option>
                    <option value="12">12 </option>
                    <option value="15">15 </option>
                    <option value="18">18 </option>
                    <option value="R18">R18 </option>
                </select>

                <p class="disclaimer">Disclaimer: Increments in .1 if using arrows</p>
                <input type="number" name="movie_rating" placeholder="Movie Rating (0-5)" min="0" max="5" step="0.1" required>
                
                <input type="submit" value='Add Movie' class="submitbtn">
            </form>
        </div>
    </div>
<?php
}
?>
<script>src = "js/adminpanel.js"</script>
</body>
</html>