<?php
session_start();
include('conn.php');


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // these make sure the login feedback message on login is only displayed once, and isn't shown again if a user clicks the browser back arrow (found on stack overflow)
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Display update messages
if(isset($_SESSION['member_success'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['member_success'] . '</div>';
    unset($_SESSION['member_success']);
}
if(isset($_SESSION['member_fail'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['member_fail'] . '</div>';
    unset($_SESSION['member_fail']);
}

// Display delete messages
if(isset($_SESSION['delete_member_success'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['delete_member_success'] . '</div>';
    unset($_SESSION['delete_member_success']);
}
if(isset($_SESSION['delete_member_fail'])) {
    echo '<div class="adminlogintoast">' . $_SESSION['delete_member_fail'] . '</div>';
    unset($_SESSION['delete_member_fail']);
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
$_SESSION['admin_logged_in'] = true;  // temporary override
if (!isset($_SESSION['admin_logged_in'])) {
    echo "<div class='alert-container'>
            <div class='AdminAlert'>
                <i class='fas fa-exclamation-triangle warning-icon'></i>
                <h1>You don't have permission to view this page!</h1>
            </div>
            <a href='index.php' class='back-to-home'>Back to Home</a>
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
            <a href="membercrud.php" class="nav-link active">
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
            <a href="adminprocessing.php" class="nav-link">
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
$adult_query = "SELECT * FROM LimelightMembers WHERE member_type = 'adult' AND member_type != 'admin' LIMIT 30";
$adult_result = mysqli_query($conn, $adult_query);

$junior_query = "SELECT * FROM LimelightMembers WHERE member_type = 'junior' AND member_type != 'admin' LIMIT 30";
$junior_result = mysqli_query($conn, $junior_query);
?>

<div class="admin-content">
   <!-- Adult Members Table -->
<h2 class="table-heading">Adult Members</h2>
<div class="table-responsive">
    <form action="updatemember.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Date of Birth</th>
                    <th>Member Type</th>
                    <th>Cinema</th>
                    <th class="action-column">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php 
if (mysqli_num_rows($adult_result) > 0) {
    while($row = mysqli_fetch_array($adult_result)) {
        echo "<tr>";
        echo "<td><input type='text' class='table-input' minlength='6' name='username[" . $row['ID'] . "]' value='" . $row['username'] . "'></td>";
        echo "<td><input type='email' class='table-input' name='email[" . $row['ID'] . "]' value='" . $row['email'] . "'></td>";
        echo "<td><input type='text' class='table-input' minlength='6' name='password[" . $row['ID'] . "]' value='" . $row['password'] . "'></td>";
        echo "<td><input type='date' class='table-input' name='dob[" . $row['ID'] . "]' value='" . $row['dob'] . "'></td>";
        echo "<td><input type='text' class='table-input' name='memberType[" . $row['ID'] . "]' value='" . $row['member_type'] . "'></td>";
        echo "<td>
            <select class='table-select' name='cinema[" . $row['ID'] . "]'>
                <option value='Fort Kinnaird' " . ($row['preferred_cinema'] == 'Fort Kinnaird' ? 'selected' : '') . ">Fort Kinnaird</option>
                <option value='Dalkeith' " . ($row['preferred_cinema'] == 'Dalkeith' ? 'selected' : '') . ">Dalkeith</option>
                <option value='Newtongrange' " . ($row['preferred_cinema'] == 'Newtongrange' ? 'selected' : '') . ">Newtongrange</option>
                <option value='Gorebridge' " . ($row['preferred_cinema'] == 'Gorebridge' ? 'selected' : '') . ">Gorebridge</option>
            </select>
        </td>";
        echo "<td>
            <input type='hidden' name='hidden[" . $row['ID'] . "]' value='" . $row['ID'] . "'>
            <button type='submit' name='update' value='" . $row['ID'] . "' class='update-btn'>Update</button>
            <button type='submit' name='delete' value='" . $row['ID'] . "' class='delete-btn'>Delete</button>
        </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No adult members found</td></tr>";
}
?>
            </tbody>
        </table>
        <div class = "update-all">
            <input type="submit" name="update_all" value="Update all Adults" class="update-btn">
        </div>
    </form>
</div>

   <!-- Junior Members Table -->
<h2 class="table-heading">Junior Members</h2>
<div class="table-responsive">
    <form action="updatemember.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Date of Birth</th>
                    <th>Member Type</th>
                    <th>Cinema</th>
                    <th class="action-column">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php 
if (mysqli_num_rows($junior_result) > 0) {
   while($row = mysqli_fetch_array($junior_result)) {
       echo "<tr>";
       echo "<td><input type='text' class='table-input' minlength='6' name='username[" . $row['ID'] . "]' value='" . $row['username'] . "'></td>";
       echo "<td><input type='email' class='table-input' name='email[" . $row['ID'] . "]' value='" . $row['email'] . "'></td>";
       echo "<td><input type='text' class='table-input' minlength='6' name='password[" . $row['ID'] . "]' value='" . $row['password'] . "'></td>";
       echo "<td><input type='date' class='table-input' name='dob[" . $row['ID'] . "]' value='" . $row['dob'] . "'></td>";
       echo "<td><input type='text' class='table-input' name='memberType[" . $row['ID'] . "]' value='" . $row['member_type'] . "'></td>";
       echo "<td>
           <select class='table-select' name='cinema[" . $row['ID'] . "]'>
               <option value='Fort Kinnaird' " . ($row['preferred_cinema'] == 'Fort Kinnaird' ? 'selected' : '') . ">Fort Kinnaird</option>
               <option value='Dalkeith' " . ($row['preferred_cinema'] == 'Dalkeith' ? 'selected' : '') . ">Dalkeith</option>
               <option value='Newtongrange' " . ($row['preferred_cinema'] == 'Newtongrange' ? 'selected' : '') . ">Newtongrange</option>
               <option value='Gorebridge' " . ($row['preferred_cinema'] == 'Gorebridge' ? 'selected' : '') . ">Gorebridge</option>
           </select>
       </td>";
       echo "<td>
           <button type='submit' name='update' value='" . $row['ID'] . "' class='update-btn'>Update</button>
           <button type='submit' name='delete' value='" . $row['ID'] . "' class='delete-btn'>Delete</button>
       </td>";
       echo "</tr>";
   }
} else {
   echo "<tr><td colspan='7'>No junior members found</td></tr>";
}
?>
            </tbody>
        </table>
        <div class = "update-all">
            <input type="submit" name="update_all" value="Update all Juniors" class="update-btn">
        </div>
    </form>
</div>
       
    <?php
}
?>
<script>src = "js/adminpanel.js"</script>
</body>
</html>