<?php
session_start();

if (isset($_SESSION['junior_login'])) {
    unset($_SESSION['junior_login']);
    header('Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/index.php');
}

exit();
?>