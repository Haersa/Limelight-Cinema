<?php
session_start();

unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_id']);
unset($_SESSION['logged_in']);  
unset($_SESSION['user_id']);    


header("Location: http://webdev.edinburghcollege.ac.uk/~HNCWEBMR11/level8php/limelightcinema/index.php");
exit();
?>