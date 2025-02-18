<?php 
session_start();
include('conn.php');

if(isset($_POST['book_tickets'])) {
    $film_id = $_POST['film_id'];
    $number_of_seats = $_POST['number_of_seats'];
    $showtime = $_POST['showtime'];
    
    $user_id = $_SESSION['user_id'];
    
    // Split showtime into date and time
    $showtime_parts = explode(" ", $showtime);
    $show_date = $showtime_parts[0];
    $show_time = $showtime_parts[1];
    
    // First check if enough tickets are available
    $check_tickets = "SELECT TicketQuantity FROM Showtimes 
                      WHERE FilmID = $film_id 
                      AND DATE(ShowDate) = '$show_date' 
                      AND ShowTime = '$show_time'";
    
    $ticket_result = mysqli_query($conn, $check_tickets);
    $ticket_row = mysqli_fetch_assoc($ticket_result);
    
    if($ticket_row['TicketQuantity'] == 0) {
        $_SESSION['booking_error'] = "No tickets left";
        header("Location: booking.php?id=" . $film_id);
        exit();
    }

    if($ticket_row['TicketQuantity'] < $number_of_seats) {
        $_SESSION['booking_error'] = "Only " . $ticket_row['TicketQuantity'] . " tickets left";
        header("Location: booking.php?id=" . $film_id);
        exit();
    }
    
    // Get user info
    $user_query = "SELECT * FROM LimelightMembers WHERE ID = '$user_id'";
    $user_result = mysqli_query($conn, $user_query);
    $user_info = mysqli_fetch_assoc($user_result);

    // Get film title
    $film_query = "SELECT FilmTitle FROM LimelightFilms WHERE FilmID = '$film_id'";
    $film_result = mysqli_query($conn, $film_query);
    $film_info = mysqli_fetch_assoc($film_result);
    $film_title = $film_info['FilmTitle'];
    
    // Get random QR code
    $qr_query = "SELECT * FROM QRCodes WHERE active = 1 ORDER BY RAND() LIMIT 1";
    $qr_result = mysqli_query($conn, $qr_query);
    $qr_code = mysqli_fetch_assoc($qr_result);
    $qr_image_path = $qr_code['image_path'];
    
    // Update tickets in Showtimes table
    $update_tickets = "UPDATE Showtimes 
                       SET TicketQuantity = TicketQuantity - $number_of_seats 
                       WHERE FilmID = $film_id 
                       AND DATE(ShowDate) = '$show_date' 
                       AND ShowTime = '$show_time' 
                       AND TicketQuantity >= $number_of_seats";
    
    if(mysqli_query($conn, $update_tickets)) {
        // Add booking to UserBookings table with QR code and film title
        $add_booking = "INSERT INTO UserBookings 
             (username, ID, user_id, dob, preferred_cinema, film_id, movie_title, showtime, 
             number_of_seats, qr_code_path) 
             VALUES 
             ('$user_info[username]', '$user_id', '$user_id', '$user_info[dob]', 
             '$user_info[preferred_cinema]', '$film_id', '$film_title', '$showtime', 
             '$number_of_seats', '$qr_image_path')";
        
        if(mysqli_query($conn, $add_booking)) {
            $_SESSION['booking_success'] = 'Booking successful <i class="fa-regular fa-circle-check" style="color: #4CAF50;"></i>';
            header("Location: tickets.php");
            exit();
        } else {
            $_SESSION['booking_error'] = "Error making booking: " . mysqli_error($conn);
            header("Location: booking.php?id=" . $film_id);
            exit();
        }
    } else {
        $_SESSION['booking_error'] = "Error updating tickets: " . mysqli_error($conn);
        header("Location: booking.php?id=" . $film_id);
        exit();
    }
} else {
    header("Location: movies.php");
    exit();
}
?>