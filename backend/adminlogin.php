
<?php
session_start(); // start session
include('conn.php'); // connection to database file

// Check if form fields are empty
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['passkey'])) {
    $_SESSION['login_fail'] = 'All fields are required <i class="fa-regular fa-circle-xmark"></i>'; // if one or more form fields are empty, alert error message to the user that all form fields are required
    header("Location: adminloginpage.php");
    exit(); // end the execution of the script
}

$username = $_POST['username']; // gather the admins username from the username input and assign to username variable
$password = $_POST['password']; // gather the admins password from the password input and assign to password variable
$passkey = $_POST['passkey']; // gather the admins inputted passkey from the passkey input and assign to passkey variable

// Hardcoded admin passkey, set in a separate variable
$admin_passkey = 'adminpasskey';

// Query to check for admin users in the LimelightMembers table
$loginquery = "SELECT * FROM LimelightMembers WHERE username = '$username' AND password = '$password' AND member_type = 'admin'"; // sql query to check if an account exists, where the username and password = the username and password the admin has submitted
$result = mysqli_query($conn, $loginquery);
$count = mysqli_num_rows($result);

if ($count === 1) { // if the match is made between inputs and database account details
    $row = mysqli_fetch_array($result);
    
    if ($passkey === $admin_passkey) { // and the passkey inputted matches to the passkey
        $_SESSION['admin_id'] = $row['ID'];
        $_SESSION['admin_logged_in'] = true; // set the admin login session flag as true
        $_SESSION['login_admin_message'] = 'Administrator Login Successful <i class="fa-regular fa-circle-check" style="color: #0066cc;"></i>'; // alert to admin login success message
        header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/adminpanel.php"); // redirect admin to secure admin panel
        exit(); // end the execution of the script
    } else {
        $_SESSION['login_fail'] = 'Incorrect Admin Passkey <i class="fa-regular fa-circle-xmark"></i>'; // if the passkey is incorrect, alert error message
        header("Location: adminloginpage.php"); // redirect back to admin login page to let them try again
        exit(); // end the execution of the script
    }
} else {
    $_SESSION['login_fail'] = 'Incorrect Username or Password <i class="fa-regular fa-circle-xmark"></i>'; // if username or password is incorrect/doesnt match, alert error message to admin
    header("Location: adminloginpage.php"); // redirect back to admin login page to let them try again
    exit(); // end the execution of the script
}

mysqli_close($conn); // close database connection
?>