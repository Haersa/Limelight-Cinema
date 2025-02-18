<?php
session_start();
include('conn.php');

if(isset($_POST['update'])) {
    $filmId = $_POST['film_id'];
    $movietitle = $_POST['title'];
    $description = $_POST['description'];
    $run_time = $_POST['runtime'];
    $directors = $_POST['directors'];
    $genre = $_POST['genres'];
    $coming_soon = $_POST['coming_soon'];
    $age_rating = $_POST['age_rating'];
    $cast = $_POST['cast'];
    $supporting_cast = $_POST['supporting_cast'];
    $movie_rating = $_POST['movie_rating'];
    $trailer = $_POST['trailer'];  
    
    
    $sql = "UPDATE LimelightFilms SET 
            FilmTitle = '$movietitle',
            Filmdesc = '$description',
            Runtime = '$run_time',
            Directors = '$directors',
            Genres = '$genre',
            Coming_Soon = '$coming_soon',
            AgeRating = '$age_rating',
            Cast = '$cast',
            SupportingCast = '$supporting_cast',
            MovieRating = '$movie_rating',
            Trailer = '$trailer'    
            WHERE FilmID = $filmId";

    // Run the update
    if(mysqli_query($conn, $sql)) {
        // If images were uploaded, update them to the database separately
        if($_FILES['thumbnail_image']['size'] > 0) {
            $thumbnail = "images/" . $_FILES['thumbnail_image']['name'];
            move_uploaded_file($_FILES['thumbnail_image']['tmp_name'], $thumbnail);
            mysqli_query($conn, "UPDATE LimelightFilms SET thumbnail_img = '$thumbnail' WHERE FilmID = $filmId");
        }
        
        if($_FILES['poster_image']['size'] > 0) {
            $poster = "images/" . $_FILES['poster_image']['name'];
            move_uploaded_file($_FILES['poster_image']['tmp_name'], $poster);
            mysqli_query($conn, "UPDATE LimelightFilms SET poster_img = '$poster' WHERE FilmID = $filmId");
        }
        
        $_SESSION['movie_success'] = 'Movie updated successfully <i class="fa-regular fa-circle-check" style="color: #0066cc;"></i>';
    } else {
        $_SESSION['movie_fail'] = "Update failed!";
    }
    
    header("Location: editmovie.php?id=" . $filmId);
    exit();
}
?>