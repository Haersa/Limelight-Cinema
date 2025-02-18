<?php
session_start(); // start session
include('conn.php'); // connection to database

if(isset($_SESSION['logged_in']) && isset($_POST['cinema'])) { // if user is logged in and the cinema location is posted
   $user_id = $_SESSION['user_id']; // get the user id from the session that is logged in
   $cinema = $_POST['cinema']; // get the new cinema they have chosen from the options
   
   $query = mysqli_query($conn, "UPDATE LimelightMembers SET preferred_cinema = '$cinema' WHERE ID = '$user_id'"); // sql query to update the new cinema location to the database, updating the cinema tied to the account logged in by the user id
   
   if($query) { // if the query was successful
       $_SESSION['update_success'] = "Cinema preference updated to $cinema"; // set success message
   } else { // if the query failed
       $_SESSION['update_fail'] = "Failed to update cinema preference"; // set error message
   }
}

$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'; 
header("Location: $redirect"); // redirect user back to the page they were on
exit(); // stop script execution
?>