<?php
session_start();
include('conn.php');

if (isset($_SESSION['login_admin_message'])) {
    ?>
    <div class="adminlogintoast">
        <?php echo $_SESSION['login_admin_message']; ?>
    </div>
    <?php
    unset($_SESSION['login_admin_message']);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/adminstyle.css">
</head>
<body>


<div class="mobile-restriction" style="display: none;">
    <div class="AdminAlert">
        <i class="fas fa-desktop warning-icon"></i>
        <h1>Desktop Access Only</h1>
        <p>The admin panel is only accessible on laptop or desktop computers.</p>
        <p>Please switch to a larger screen to manage the site's content.</p>
    </div>
    <form action="logout.php" method="POST">
        <input type="hidden" name="redirect" value="index.php">
        <button type="submit" class="back-to-home">Back to Home</button>
    </form>
</div>

<?php
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
            <a href="adminpanel.php" class="nav-link active">
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

    <main class="admin-content">
        <div class="statistics-grid">
            <div class="stat-card">
                <h2>Tickets Booked Today</h2>
                <p class="stat-number">125</p>
            </div>
            <div class="stat-card">
                <h2>Tickets Booked This Week</h2>
                <p class="stat-number">876</p>
            </div>
        </div>

        <div class="upcoming-screenings">
            <h2>Upcoming Movie Screenings</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Movie</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Available Seats</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>The Matrix Resurrections</td>
                            <td>2023-05-15</td>
                            <td>19:30</td>
                            <td>45</td>
                        </tr>
                        <tr>
                            <td>Dune</td>
                            <td>2023-05-16</td>
                            <td>20:00</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td>No Time to Die</td>
                            <td>2023-05-17</td>
                            <td>18:45</td>
                            <td>55</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="messages-section">
        <div class="messages-section" id="messages">
    <div class="messages-header">
        <h2>Contact Messages</h2>
        <form method="GET" class="filter-form" action="#messages">
    <select name="sort" class="filter-select">
        <option value="newest" 
            <?php 
            if(!isset($_GET['sort']) || $_GET['sort'] == 'newest') {
                echo "selected";
            }
            ?>>
            Newest First
        </option>
        <option value="oldest" 
            <?php 
            if(isset($_GET['sort']) && $_GET['sort'] == 'oldest') {
                echo "selected";
            }
            ?>>
            Oldest First
        </option>
    </select>
</form>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Replied</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sortOrder = (isset($_GET['sort']) && $_GET['sort'] == 'oldest') ? 'ASC' : 'DESC';
                $query = "SELECT * FROM ContactMessages ORDER BY SubmissionID $sortOrder";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['SubmissionID']; ?></td>
                            <td><?php echo htmlspecialchars($row['Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Email']); ?></td>
                            <td><?php echo htmlspecialchars($row['Message']); ?></td>
                            <td>
                                <input type="checkbox" 
                                       onchange="showConfirmModal(<?php echo $row['SubmissionID']; ?>)" 
                                       class="reply-checkbox">
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5">No messages found</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div id="confirmModal" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Confirm this message has been replied to? It will be deleted from the system.</p>
        <form method="POST" action="deletemessage.php" id="confirmForm">
            <input type="hidden" name="message_id" id="messageIdInput">
            <button type="button" onclick="closeModal()" class="cancel-btn">Cancel</button>
            <button type="submit" name="confirm_delete" class="confirm-btn">Confirm</button>
        </form>
    </div>
</div>


</main>

<?php
} 
?>      
       

<script src = "js/adminpanel.js"></script>
</body>
</html>