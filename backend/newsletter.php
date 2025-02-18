<?php
session_start(); // start session
include 'conn.php'; // database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") { // check if form was submitted via POST
    $name = $_POST['name']; // get name from form input
    $email = $_POST['email']; // get email from form input
    
    // First check if email already exists
    $checkQuery = "SELECT * FROM LimelightNewsletter WHERE Email = '$email'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        // Email already exists
        $_SESSION['newsletter_fail'] = 'You are already subscribed! <i class="fa-regular fa-circle-xmark"></i>';
    } else {
        // Add new subscriber
        $insertQuery = "INSERT INTO LimelightNewsletter (Name, Email) VALUES ('$name', '$email')";
        
        if(mysqli_query($conn, $insertQuery)) {
            $_SESSION['newsletter_message'] = 'Thanks for subscribing! <i class="fa-regular fa-circle-check" style="color: #4CAF50;"></i>';
        } else {
            $_SESSION['newsletter_fail'] = 'Subscription failed. Please try again. <i class="fa-regular fa-circle-xmark"></i>';
        }
    }
    
    mysqli_close($conn); // close database connection
    header("Location: " . $_SERVER['HTTP_REFERER']); // redirect back to the previous page
    exit(); // end script execution
}