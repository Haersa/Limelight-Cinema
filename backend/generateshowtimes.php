<?php
session_start();
include('conn.php');

if(isset($_GET['id'])) {
    $filmId = $_GET['id'];
    
    // Get showtimes from ShowtimeList
    $query = "SELECT Showtime FROM ShowtimeList";
    $result = mysqli_query($conn, $query);
    
    $showtimes = array();
    while($row = mysqli_fetch_assoc($result)) {
        $showtimes[] = $row['Showtime'];
    }
    
    // Delete existing showtimes for this film only
    $delete = "DELETE FROM Showtimes WHERE FilmID = $filmId";
    mysqli_query($conn, $delete);
    
    // Generate new showtimes
    for($day = 0; $day < 7; $day++) {
        $date = date('Y-m-d', strtotime("+$day day"));
        
        // Generate for each cinema
        for($cinema = 1; $cinema <= 4; $cinema++) {
            // Create a copy of showtimes array so each cinema gets fresh times
            $availableTimes = $showtimes;
            shuffle($availableTimes);
            $cinemaShowtimes = array_slice($availableTimes, 0, 2);
            
            foreach($cinemaShowtimes as $time) {
                $insert = "INSERT INTO Showtimes (FilmID, CinemaID, ShowDate, ShowTime, TicketQuantity) 
                          VALUES ($filmId, $cinema, '$date', '$time', 80)";
                mysqli_query($conn, $insert);
            }
        }
    }
    
    $_SESSION['showtime_success'] = "Showtimes generated successfully";
    header("Location: moviecrud.php");
    exit();
} else {
    $_SESSION['showtime_fail'] = "Showtime generation failed";
    header("Location: moviecrud.php");
    exit();
}
?>