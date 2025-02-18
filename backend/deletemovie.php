<?php
session_start(); // start session
include('conn.php'); // database connection file

if(isset($_GET['id'])) {
    $movieId = $_GET['id']; // get the id of the movie that the admin clicked on
    
    
    $query = "SELECT thumbnail_img, poster_img FROM LimelightFilms WHERE FilmID = $movieId";
    $result = mysqli_query($conn, $query);
    
    if($movie = mysqli_fetch_assoc($result)) {
        // Delete the actual files if they exist inside the images folder using the unlink function
        if(file_exists($movie['thumbnail_img'])) {
            unlink($movie['thumbnail_img']);
        }
         // Delete the actual files if they exist inside the images folder using the unlink function
        if(file_exists($movie['poster_img'])) {
            unlink($movie['poster_img']);
        }
    }
    
    // Delete the database row/data, to remove all movie information from the database
    $delete_query = "DELETE FROM LimelightFilms WHERE FilmID = $movieId";
    
    if(mysqli_query($conn, $delete_query)) {
        $_SESSION['delete_success'] = 'Movie deleted successfully <i class="fa-regular fa-circle-check" style="color: #0066cc;"></i>'; // set successful deletion message, to be shown to admin
    } else {
        $_SESSION['delete_fail'] = 'Failed to delete movie <i class="fa-regular fa-circle-xmark"></i>'; // set failed deletion message, to alert admin the deletion didnt work
    }
}

header("Location: moviecrud.php"); // redirect back to movie crud page, to allow admin to choose other movies from the database
exit();
?>