<?php
session_start();
include('conn.php');

// Display creation message
if(isset($_SESSION['update_success'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['update_success'] . '</div>';
    unset($_SESSION['update_success']);
}
if(isset($_SESSION['update_fail'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['update_fail'] . '</div>';
    unset($_SESSION['update_fail']);
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Member Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/adminstyle.css">
</head>
<body>
<?php
if (!isset($_SESSION["admin_logged_in"])) {
    echo "<div class='alert-container'>
            <div class='AdminAlert'>
                <i class='fas fa-exclamation-triangle warning-icon'></i>
                <h1>You don't have permission to view this page!</h1>
                <p>Please log in with admin credentials to access this area.</p>
            </div>
            <form action='logout.php' method='POST'>
                <input type='hidden' name='redirect' value='index.php'>
                <button type='submit' class='back-to-home'>Back to Home</button>
            </form>
          </div>";
} else {
    ?>
   


   <nav class="navbar">
    <ul class="navbar-nav">
        <li class="logo">
            <a class="nav-link">
                <span class="link-text logo-text">Admin Panel</span>
                <i class="fas fa-angle-double-right"></i>
            </a>
        </li>
        <li class="nav-item">
            <a href="adminpanel.php" class="nav-link">
                <i class="fas fa-home fa-2x"></i>
                <span class="link-text">Admin Panel</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="membercrud.php" class="nav-link">
                <i class="fas fa-user-edit fa-2x"></i>
                <span class="link-text">Member Management</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="fileuploader.php" class="nav-link">
                <i class="fas fa-plus-circle fa-2x"></i>
                <span class="link-text">Add a Movie</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="moviecrud.php" class="nav-link">
                <i class="fa-solid fa-pen-to-square"></i>
                <span class="link-text">Movie Management</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="addadmin.php" class="nav-link active">
                <i class="fas fa-user-plus fa-2x"></i>
                <span class="link-text">Add an Admin</span>
            </a>
        </li>
        <li class="nav-item" id="logout">
            <a href="adminlogout.php" class="nav-link">
                <i class="fas fa-sign-out-alt fa-2x"></i>
                <span class="link-text">Sign out</span>
            </a>
        </li>
    </ul>
</nav>

<?php

?>

<div class="admin-content">

<div class="form-container">
    <div class="form-header">
        <h2>Create New Admin Account</h2>
    </div>
    
    <form action="process_admin.php" method="POST" class="admin-form">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" 
                   id="username" 
                   name="username" 
                   required 
                   class="form-control"
                   placeholder="Enter admin username">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   required 
                   class="form-control"
                   placeholder="Enter admin password">
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" 
                   id="confirm_password" 
                   name="confirm_password" 
                   required 
                   class="form-control"
                   placeholder="Confirm admin password">
        </div>

        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" 
                   id="dob" 
                   name="dob" 
                   required 
                   class="form-control">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Create Admin Account</button>
            <button type="reset" class="btn-reset">Reset Form</button>
        </div>
    </form>
</div>


       
    <?php
}
?>
<script>src = "js/adminpanel.js"</script>
</body>
</html>