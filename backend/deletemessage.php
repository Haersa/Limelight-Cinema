<?php
session_start(); // start session
include('conn.php'); // database connection file

if(isset($_POST['message_id'])) { 
    $messageId = $_POST['message_id']; // variable to store the message id 
    $deleteQuery = "DELETE FROM ContactMessages WHERE SubmissionID = $messageId"; // sql query to delete the message from the database where the submission id and variable of messageid match
    mysqli_query($conn, $deleteQuery); // run the delete query to delete the message from the database
    header('Location: adminpanel.php'); // redirect to admin panel, to refresh the page and show the admin the message has been deleted
}
?>