<?php
session_start();
include('conn.php');


// Check if form fields are empty
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
    $_SESSION['contact_fail'] = 'All fields are required <i class="fa-regular fa-circle-xmark"></i>'; // alert error message to user that all form fields need to be filled
    header("Location: contact.php"); // redirect back to contact page to let user try again
    exit(); // end the execution of the script
}

// Check if form is submitted
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    
    // Get the form field data from the inputs and assign to variables
    $name =  $_POST['name']; // users name
    $email =  $_POST['email']; // users email
    $message =  $_POST['message']; // users message
    
    // Insert the contact form into the database
    $query = "INSERT INTO ContactMessages (Name, Email, Message) VALUES ('$name', '$email', '$message')"; // sql query to insert the contact form submission into the database
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['contact_success'] = 'Message sent!<i class="fa-regular fa-circle-check" style="color: #4CAF50;"></i>'; // if contact form submission is successfully inserted into database, alert success message to the user
    } else {
        $_SESSION['contact_fail'] = 'Failed to send message <i class="fa-regular fa-circle-xmark"></i>';// if contact form submission is fails to insert into database, alert failed message to the user 
    }
    
    header("Location: contact.php"); // refresh page on either successful or failed submission to remove the user inputs from the fields
    exit(); // end the execution of the script
}
?>