<?php
session_start(); // start session
include 'conn.php'; // database connection file

if (isset($_POST['update'])) { 
   $id = $_POST['update']; // Get ID from the button value that was clicked
   $username = $_POST['username'][$id]; // get username from form input array using the ID as key
   $password = $_POST['password'][$id]; // get password from form input array using the ID as key
   
   $UpdateQuery = "UPDATE LimelightMembers 
                  SET username = '$username',
                      password = '$password'
                  WHERE ID = '$id' AND member_type = 'admin'"; // sql query to update admin account information, making sure to only update admin accounts
   
   if(mysqli_query($conn, $UpdateQuery)) {
       $_SESSION['update_success'] = 'Admin Updated Successfully <i class="fa-regular fa-circle-check" style="color: #0066cc;"></i>'; // if admin information has been updated successfully, alert admin via success message
   } else {
       $_SESSION['update_fail'] = 'Update Failed <i class="fa-regular fa-circle-xmark"></i>'; // if admin information update has failed, alert admin via failure message
   }
   header("Location: adminprocessing.php"); // redirect back to admin processing page after update
}

if (isset($_POST['delete'])) { 
   $id = $_POST['delete']; // Get ID from the button value that was clicked
   $DeleteQuery = "DELETE FROM LimelightMembers WHERE ID = '$id' AND member_type = 'admin'"; // sql query to delete the admin account based on ID, ensuring only admin accounts can be deleted
   
   if(mysqli_query($conn, $DeleteQuery)) {
       $_SESSION['delete_success'] = 'Admin Deleted Successfully <i class="fa-regular fa-circle-check" style="color: #0066cc;"></i>'; // alert successful deletion via feedback message
   } else {
       $_SESSION['delete_fail'] = 'Delete Failed <i class="fa-regular fa-circle-xmark"></i>'; // if deletion fails, alert via feedback message
   }
   header("Location: adminprocessing.php"); // redirect back to admin processing page after deletion attempt
}

if (isset($_POST['create'])) { 
   $CreateQuery = "INSERT INTO LimelightMembers (username, password, dob, member_type, preferred_cinema) 
                  VALUES ('$_POST[username]', '$_POST[password]', '0000-00-00', 'admin', NULL)"; // sql query to create new admin account with default admin values
   
   if(mysqli_query($conn, $CreateQuery)) {
       $_SESSION['update_success'] = 'Account Created Successfully <i class="fa-regular fa-circle-check" style="color: #0066cc;"></i>'; // alert successful account creation via feedback message
   } else {
       $_SESSION['update_fail'] = 'Creation Failed <i class="fa-regular fa-circle-xmark" ></i>'; // if creation fails, alert via feedback message
   }
   header("Location: adminprocessing.php"); // redirect back to admin processing page after creation attempt
}

if (isset($_POST['update_all'])) { // if update all button is clicked
   $success = true; // set initial success flag to true
   
   foreach($_POST['username'] as $id => $username) { // loop through all usernames in the form array
       $UpdateQuery = "UPDATE LimelightMembers 
                      SET username = '$username',
                          password = '{$_POST['password'][$id]}'
                      WHERE ID = '$id' 
                      AND member_type = 'admin'"; // sql query to update each admin account using ID as reference
       
       if(!mysqli_query($conn, $UpdateQuery)) { // if any update fails
           $success = false; // set success flag to false
           break; // exit the loop if any update fails
       }
   }
   
   if($success) {
       $_SESSION['update_success'] = 'All accounts updated successfully <i class="fa-regular fa-circle-check" style="color: #0066cc;"></i>'; // if all updates successful, show success message
   } else {
       $_SESSION['update_fail'] = 'Update all failed <i class="fa-regular fa-circle-xmark"></i>'; // if any update failed, show failure message
   }
   header("Location: adminprocessing.php"); // redirect back to admin processing page after update all update attempt
}

mysqli_close($conn); // close database connection
exit();  // end the execution of the script
?>