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

// Get the user's bookings
$user_id = $_SESSION['user_id'];
$query = "SELECT b.id, r.name AS room_name, b.check_in_date, b.check_out_date, b.total_price, b.status 
          FROM bookings b 
          JOIN rooms r ON b.room_id = r.id 
          WHERE b.user_id = ? 
          ORDER BY b.check_in_date DESC";

$stmt = $connect->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Grand Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Breadcrumb Navigation -->
    <div class="col-12 my-5 mb-4 px-4">
        <div style="font-size: 14px;">
            <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
            <span class="text-secondary"> > </span>
            <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
            <span class="text-secondary"> > </span>
            <span class="text-dark">My Bookings</span>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="text-center">My Bookings</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['room_name']); ?></td>
                        <td><?php echo $row['check_in_date']; ?></td>
                        <td><?php echo $row['check_out_date']; ?></td>
                        <td>Rs <?php echo $row['total_price']; ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                        <td>
                            <?php if ($row['status'] == 'pending') { ?>
                                <form method="POST" action="cancel_booking.php">
                                    <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                </form>
                            <?php } else { ?>
                                <span class="text-muted">Not Allowed</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php $connect->close(); ?>
