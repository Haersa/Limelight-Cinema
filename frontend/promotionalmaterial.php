<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Promo Material</title>
    <link rel="stylesheet" href="css/promoupload.css">
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
    echo '<div class="adminlogintoast">' . $_SESSION["upload_success"] . "</div>";
    unset($_SESSION["upload_success"]);
}

if (isset($_SESSION["upload_fail"])) {
    echo '<div class="adminlogintoast"><i class="fas fa-times-circle"></i> ' .
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
   

   <div class="promo-admin-content">
    <div class="promo-nav-links">
        <a href='adminpanel.php' class="promo-back-link">
            <i class="fas fa-arrow-left"></i> Back to Admin Panel
        </a>
        <a href='adminlogout.php' class="promo-signout-link">
            <i class="fas fa-sign-out-alt"></i> Sign out
        </a>
    </div>

    <h1 class="promo-title">Add Promotional Material</h1>
    
    <div class="promo-wrapper">
        <div class="promo-card">
        <form class="promo-form" action="uploadpromo.php" method="POST" enctype="multipart/form-data">
    <p class="promo-disclaimer">Only Image File Formats are accepted (JPG, PNG, GIF). Max size: 5MB</p>
    
    <label for="promo_title" class="promo-label">Title:</label>
    <input 
        type="text" 
        name="promo_title" 
        id="promo_title" 
        required
        class="promo-input"
        placeholder="Enter title for promotional material"
    >

    <label for="promo_image" class="promo-label">Promotional Image:</label>
    <input 
        type="file" 
        name="promo_image" 
        id="promo_image" 
        accept="image/*" 
        required
        class="promo-file-input"
    >
    
    <textarea 
        name="description" 
        placeholder="Description of promotional material" 
        required
        class="promo-textarea"
    ></textarea>
    <div class="promo-checkbox-group">
        <input type="checkbox" id="promo_movie" name="promo_movie" class="promo-checkbox">
        <label for="promo_movie" class="promo-label checkbox-label">Movie Promotion</label>
    </div>

    <input type="submit" value="Upload Material" class="promo-submit">
</form>
        </div>
    </div>
</div>

<?php
}
?>
<script>src = "js/adminpanel.js"</script>
</body>
</html>