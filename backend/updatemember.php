<?php
session_start(); // start session
include 'conn.php'; // database connection file

if (isset($_POST['update'])) { 
   $id = $_POST['update']; // Get ID from the button value that was clicked
   $username = $_POST['username'][$id]; // get username from form input array using the ID as key
   $password = $_POST['password'][$id]; // get password from form input array using the ID as key
   $email = $_POST['email'][$id]; // get email from form input array using the ID as key
   $dob = $_POST['dob'][$id]; // get date of birth from form input array using the ID as key 
   $memberType = $_POST['memberType'][$id]; // get member type from form input array using the ID as key
   $cinema = $_POST['cinema'][$id]; // get preferred cinema from form input array using the ID as key

   $UpdateQuery = "UPDATE LimelightMembers 
                  SET username = '$username', 
                      email = '$email',
                      password = '$password', 
                      dob = '$dob', 
                      member_type = '$memberType', 
                      preferred_cinema = '$cinema' 
                  WHERE ID = '$id'"; // sql query to update the members information based on the form inputs, using ID to identify correct member

   if(mysqli_query($conn, $UpdateQuery)) {
       $_SESSION['member_success'] = 'Member Updated Successfully <i class="fa-regular fa-circle-check" style="color: #0066cc;"></i>'; // if member information has been updated successfully, alert admin via success message
   } else {
       $_SESSION['member_fail'] = 'Update Failed <i class="fa-regular fa-circle-xmark"></i>'; // if member information update has failed, alert admin via failure message
   }
   header("Location: membercrud.php"); // redirect back to member management page after update attempt
}

if (isset($_POST['delete'])) { // if delete button is clicked
   $id = $_POST['delete']; // Get ID from the button value that was clicked
   $DeleteQuery = "DELETE FROM LimelightMembers WHERE ID = '$id'"; // sql query to delete member account based on ID
   
   if(mysqli_query($conn, $DeleteQuery)) {
       $_SESSION['delete_member_success'] = 'Member Deleted Successfully <i class="fa-regular fa-circle-check" style="color: #0066cc;"></i>'; // alert successful deletion via feedback message
   } else {
       $_SESSION['delete_member_fail'] = 'Delete Failed <i class="fa-regular fa-circle-xmark"></i>'; // if deletion fails, alert via feedback message
   }
   header("Location: membercrud.php"); // redirect back to member management page after deletion attempt
}

if (isset($_POST['update_all'])) { // if update all button is clicked
   $success = true; // set initial success flag to true
   
   foreach($_POST['username'] as $id => $username) { // loop through all members in the form array
       $UpdateQuery = "UPDATE LimelightMembers 
                      SET username = '$username', 
                        email = '$email', 
                          password = '{$_POST['password'][$id]}', 
                          dob = '{$_POST['dob'][$id]}', 
                          member_type = '{$_POST['memberType'][$id]}', 
                          preferred_cinema = '{$_POST['cinema'][$id]}'  
                      WHERE ID = '$id'"; // sql query to update each member's information using ID as reference
       
       if(!mysqli_query($conn, $UpdateQuery)) { // if any update fails
           $success = false; // set success flag to false
           break; // exit the loop if any update fails
       }
   }
   
   if($success) {
       $_SESSION['member_success'] = 'All Members Updated Successfully <i class="fa-regular fa-circle-check" style="color: #0066cc;"></i>'; // if all updates successful, show success message
   } else {
       $_SESSION['member_fail'] = 'Update All Failed <i class="fa-regular fa-circle-xmark"></i>'; // if any update failed, show failure message
   }
   header("Location: membercrud.php"); // redirect back to member management page after bulk update attempt
}

mysqli_close($conn); // close database connection
exit();  // end the execution of the script
?>