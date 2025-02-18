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

// Display delete messages
if(isset($_SESSION['delete_success'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['delete_success'] . '</div>';
    unset($_SESSION['delete_success']);
}
if(isset($_SESSION['delete_fail'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['delete_fail'] . '</div>';
    unset($_SESSION['delete_fail']);
}



$admin_query = "SELECT * FROM LimelightMembers WHERE member_type = 'admin' LIMIT 10";
$admin_result = mysqli_query($conn, $admin_query); // sql query to pull the admin members from the database

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin Information</title>
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
            <i class="fa-solid fa-user-tie"></i>
                <span class="link-text">Manage Admins</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="promotionalmaterial.php" class="nav-link">
            <i class="fa-solid fa-newspaper"></i>
                <span class="link-text">Promotional Material</span>
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
<!-- Admin Members Table -->
<h2 class="table-heading">Admin Members</h2>
<div class="table-responsive">
    <form action="processadmin.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Member Type</th>
                    <th class="action-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if (mysqli_num_rows($admin_result) > 0) {
                    while($row = mysqli_fetch_array($admin_result)) {
                        echo "<tr>";
                        echo "<td><input type='text' class='table-input' minlength='6' name='username[" . $row['ID'] . "]' value='" . $row['username'] . "'></td>";
                        echo "<td><input type='text' class='table-input' minlength='6' name='password[" . $row['ID'] . "]' value='" . $row['password'] . "'></td>";
                        echo "<td><input type='text' class='table-input' readonly name='memberType[" . $row['ID'] . "]' value='" . $row['member_type'] . "'></td>";
                        echo "<td>
                            <button type='submit' name='update' value='" . $row['ID'] . "' class='update-btn'>Update</button>
                            <button type='submit' name='delete' value='" . $row['ID'] . "' class='delete-btn'>Delete</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No admin members found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class = "update-all">
            <input type="submit" name="update_all" value="Update All" class="update-btn">
        </div>
    </form>
</div>

    <!-- Create New Admin Form -->
    <h2 class="table-heading">Create New Admin</h2>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Member Type</th>
                    <th class="action-column">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <form action="processadmin.php" method="POST">
                        <td>
                            <input type="text" class="table-input" minlength="6" name="username" required>
                        </td>
                        <td>
                            <input type="text" class="table-input" minlength="6" name="password" required>
                        </td>
                        <td>
                            <input type="text" class="table-input" name="memberType" value="admin" readonly>
                        </td>
                        <td>
                            <input type="submit" name="create" value="Create" class="update-btn">
                            <input type="reset" value="Reset" class="delete-btn">
                        </td>
                    </form>
                </tr>
            </tbody>
        </table>
    </div>
</div>

       
    <?php
}
?>
<script>src = "js/adminpanel.js"</script>
</body>
</html>