<?php
session_start(); // start session
include('conn.php'); // connection to database file

// these make sure the login feedback message on login is only displayed once, and isn't shown again if a user clicks the browser back arrow (found on stack overflow)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


$username = $_POST['username']; // gather username input into username variable
$password = $_POST['password']; // gather password input into password variable

// check if username exists
$usernamequery = "SELECT * FROM LimelightMembers WHERE username = '$username'";
$usernamecheck = mysqli_query($conn, $usernamequery);

if (mysqli_num_rows($usernamecheck) === 0) { // if username doesn't exist
    $_SESSION['login_fail'] = 'Username Not Recognised <i class="fa-regular fa-circle-xmark"></i>'; // alert username not recognized to user
    header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/loginpage.php"); // redirect to login page to let user try again
    mysqli_close($conn);
    exit();
}

$loginquery = "SELECT * FROM LimelightMembers WHERE username = '$username' AND password = '$password'"; // sql query to check for an account with the same username & password the user has entered
$check = mysqli_query($conn, $loginquery);
$count = mysqli_num_rows($check);

if ($count === 1) { // if count = 1
    $row = mysqli_fetch_array($check);
    if ($row ['member_type'] == 'junior') {
        $_SESSION['junior_login'] = true; // set junior login session flag to true
        $_SESSION['junior_message'] = 'Sign in Successful <i class="fa-regular fa-circle-check" style="color: #ff6b6b;"></i>';
        header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/juniorindex.php"); // redirect to junior index page on successful login
    }
    else{
        $_SESSION['user_id'] = $row['ID']; // set the session to log in based on the users id, used for displaying their home cinema etc
        $_SESSION['logged_in'] = true; // set logged in session flag as true
        $_SESSION['login_message'] = 'Sign in Successful <i class="fa-regular fa-circle-check" style="color: #4CAF50;"></i>'; // alert successful login message to user
        header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/index.php"); // redirect to index page on successful login
    }

} 


else {
    $_SESSION['login_fail'] = 'Incorrect Password <i class="fa-regular fa-circle-xmark"></i>'; // if a match hasnt been made between the user inputs and account in the database, alert failed login message to user
    header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/loginpage.php"); // redirect back to login page to let user try again
}




mysqli_close($conn); // close connection
exit(); // end the execution of the script
?>