<?php
session_start();
include('conn.php');

$upload_dir = "images/"; 
$promo_image = $upload_dir . $_FILES['promo_image']['name'];
$title = mysqli_real_escape_string($conn, $_POST['promo_title']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$promo_movie = isset($_POST['promo_movie']) ? 'yes' : 'no';

if (move_uploaded_file($_FILES['promo_image']['tmp_name'], $promo_image)) {
    $sql = "INSERT INTO PromoMaterial (title, image, description, upload_date, promo_movie) 
            VALUES ('$title', '$promo_image', '$description', CURRENT_TIMESTAMP, '$promo_movie')";
            
    if (mysqli_query($conn, $sql)) {
        $_SESSION['upload_success'] = 'Material Added Successfully <i class="fa-regular fa-circle-check" style="color: #0066cc;"></i>';
    } else {
        $_SESSION['upload_fail'] = 'Failed to add to database <i class="fa-regular fa-circle-xmark"></i>';
    }
} else {
    $_SESSION['upload_fail'] = 'Upload Failed <i class="fa-regular fa-circle-xmark"></i>';
}

header("Location: promotionalmaterial.php");
exit();
?>