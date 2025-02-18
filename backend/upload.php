<?php
session_start(); 
include('conn.php'); 

    $movietitle = $_POST['title'];
    $upload_dir = "images/";
    
    $thumbnail_image = $upload_dir . basename($_FILES['thumbnail_image']['name']);
    $db_thumbnail_path = $thumbnail_image;
    
    $poster_image = $upload_dir . basename($_FILES['poster_image']['name']);
    $db_poster_path = $poster_image;
    
    $description = $_POST['description'];
    $run_time = $_POST['runtime'];
    $movie_rating = $_POST['movie_rating']; 
    $trailer = $_POST['trailer']; 
    
    function split_inputs($string) {
        $array = explode(',', $string);
        $array = array_map('trim', $array);
        return implode(', ', $array);
    }
    
    $genre = split_inputs($_POST['genres']);
    $cast = split_inputs($_POST['cast']);
    $directors = split_inputs($_POST['directors']);
    $supporting_cast = split_inputs($_POST['supporting_cast']);
    
    $coming_soon = $_POST['coming_soon'];
    $age_rating = $_POST['age_rating'];
    
    $upload_success = true;
    
    if ($_FILES['thumbnail_image']['size'] > 5000000) {
        $upload_success = false;
        $_SESSION['upload_fail'] = 'Thumbnail image is too large (max 5MB)';
    }
    
    if ($_FILES['poster_image']['size'] > 5000000) {
        $upload_success = false;
        $_SESSION['upload_fail'] = 'Poster image is too large (max 5MB)';
    }
    
    if ($upload_success) {
        if(!move_uploaded_file($_FILES['thumbnail_image']['tmp_name'], $thumbnail_image)){
            $upload_success = false;
        }
        if(!move_uploaded_file($_FILES['poster_image']['tmp_name'], $poster_image)){
            $upload_success = false;
        }
    }
    
    if($upload_success){
        $sql = "INSERT INTO LimelightFilms (FilmTitle, Filmdesc, thumbnail_img, poster_img, Runtime, Directors, Genres, Coming_Soon, AgeRating, Cast, SupportingCast, MovieRating, Trailer)
                VALUES ('$movietitle', '$description', '$db_thumbnail_path', '$db_poster_path', '$run_time', '$directors', '$genre', '$coming_soon', '$age_rating', '$cast', '$supporting_cast', '$movie_rating', '$trailer')";
        
        if(mysqli_query($conn, $sql)){
            $_SESSION['upload_success'] = 'Movie Creation Successful <i class="fa-regular fa-circle-check" style="color: #4CAF50;"></i>';
        } else {
            $_SESSION['upload_fail'] = 'Movie Creation Failed <i class="fa-regular fa-circle-xmark"></i>';
        }
    } else {
        if (!isset($_SESSION['upload_fail'])) {
            $_SESSION['upload_fail'] = 'Image Upload Failed <i class="fa-regular fa-circle-xmark"></i>';
        }
    }
    
    header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/fileuploader.php");
    exit();

?>