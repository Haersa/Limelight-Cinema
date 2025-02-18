<?php

include('conn.php'); // database connection file
session_start(); // session start

// Check if any required fields are empty
if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || 
   empty($_POST['confirmPassword']) || empty($_POST['dob'])) {
   $_SESSION['register_message'] = "All fields are required."; // alert to user that not all form fields are filled error message
   header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/registerpage.php"); // redirect user back to register page to let them try again
   exit();
}

$username = $_POST['username']; // gather username input and assign to username variable
$email = $_POST['email']; // gather email input and assign to email variable 
$password = $_POST['password']; // gather password input and assign to password variable
$confirmPassword = $_POST['confirmPassword']; // gather confirm password input and assign to confirm password variable
$dateofbirth = $_POST['dob']; // gather dob input and assign to date of birth variable
$preferred_cinema = $_POST['preferred_cinema']; // gather preferred_cinema input and assign to preferred_cinema  variable

// Check if passwords match
if ($password !== $confirmPassword) { // if passwords dont match
   $_SESSION['register_message'] = "Passwords do not match. Try again."; // alert passwords dont match error message to the user
   header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/registerpage.php");// redirect user back to register page to let them try again
   exit(); 
} 

else {
   // Calculate age and determine member type
   list($year, $month, $day) = explode("-", $dateofbirth);
   $birthday = mktime(0, 0, 0, $month, $day, $year);
   $difference = time() - $birthday;
   $age = floor($difference / 31556926);
   $member_type = ($age < 18) ? 'junior' : 'adult';

   // Check if username already exists
   $sql = mysqli_query($conn, "SELECT * FROM LimelightMembers WHERE username = '$username' OR email = '$email'");
   if (mysqli_num_rows($sql) > 0) { // if the check finds an account with the same username
       $_SESSION['register_message'] = "Username or email already exists."; // alert to user that the username already exists
       header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/registerpage.php"); // redirect user back to register page to let them try again
       exit(); 
   } 

   else {
       // Insert new user into the database
       $insert_query = "INSERT INTO LimelightMembers (username, email, password, dob, member_type, preferred_cinema) 
                       VALUES ('$username', '$email', '$password', '$dateofbirth', '$member_type', '$preferred_cinema')";

       if (mysqli_query($conn, $insert_query)) {
           $user_id = mysqli_insert_id($conn); // Get the ID of the newly inserted user
           
           // Handle newsletter subscription if checked
           if (isset($_POST['newslettercheckbox']) && $_POST['newslettercheckbox'] == 'yes') {
               $checkQuery = "SELECT * FROM LimelightNewsletter WHERE Email = '$email'";
               $checkResult = mysqli_query($conn, $checkQuery);
               
               if (mysqli_num_rows($checkResult) == 0) {
                   $insertQuery = "INSERT INTO LimelightNewsletter (Name, Email) VALUES ('$username', '$email')";
                   mysqli_query($conn, $insertQuery);
               }
           }

           // Set session variables based on member type
           if ($member_type == 'junior') {
               $_SESSION['junior_login'] = true;
               $_SESSION['login_message'] = 'Registration Successful <i class="fa-regular fa-circle-check"></i>';
               header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/juniorindex.php");
           } else {
               $_SESSION['user_id'] = $user_id;
               $_SESSION['logged_in'] = true;
               $_SESSION['login_message'] = 'Registration Successful <i class="fa-regular fa-circle-check"></i>';
               header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/index.php");
           }
           exit();
       } else {
           $_SESSION['register_message'] = "Error: Please try again " . mysqli_error($conn);
           header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/registerpage.php");
           exit(); 
       }
   }
}

mysqli_close($conn); // close connection
?>