<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$hostname = "localhost";
$database = "grandhotel";
$username = "root";
$password = "";

// Connect to the database
$connect = new mysqli($hostname, $username, $password, $database);
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Process cancellation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    $booking_id = intval($_POST['booking_id']);
    $user_id = $_SESSION['user_id'];

    // Check if the booking belongs to the logged-in user and is pending
    $query = "SELECT * FROM bookings WHERE id = ? AND user_id = ? AND status = 'pending'";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("ii", $booking_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Update booking status to 'cancelled'
        $update_query = "UPDATE bookings SET status = 'cancelled' WHERE id = ?";
        $stmt = $connect->prepare($update_query);
        $stmt->bind_param("i", $booking_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Booking cancelled successfully!'); window.location.href = 'mybooking.php';</script>";
        } else {
            echo "<script>alert('Error cancelling the booking. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Invalid booking or booking cannot be cancelled.');</script>";
    }
}
$connect->close();
?>
