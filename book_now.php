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

// Establish a connection to the database
$connect = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Validate room_id
if (!isset($_GET['room_id']) || !is_numeric($_GET['room_id'])) {
    die("Invalid room ID.");
}

$room_id = intval($_GET['room_id']);

// Fetch room details
$query = "SELECT * FROM `rooms` WHERE `id` = ? AND `status` = 1 AND `removed` = 0";
$stmt = $connect->prepare($query);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Room not available.");
}

$room_data = $result->fetch_assoc();

// Handle booking form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // Validate check-in and check-out dates
    $today = date("Y-m-d");

    if ($check_in < $today) {
        echo "<script>alert('Check-in date cannot be in the past.');</script>";
    } elseif (strtotime($check_in) >= strtotime($check_out)) {
        echo "<script>alert('Check-out date must be later than check-in date.');</script>";
    } else {
        // Check room availability
        $availability_query = "SELECT * FROM `bookings` WHERE `room_id` = ? 
                               AND `status` = 'confirmed'
                               AND (`check_in_date` < ? AND `check_out_date` > ?)";
        $stmt = $connect->prepare($availability_query);
        $stmt->bind_param("iss", $room_id, $check_out, $check_in);
        $stmt->execute();
        $availability_result = $stmt->get_result();

        if ($availability_result->num_rows > 0) {
            echo "<script>alert('This room is already booked for the selected dates. Please choose different dates.');</script>";
        } else {
            // Calculate total price
            $check_in_date = new DateTime($check_in);
            $check_out_date = new DateTime($check_out);
            $interval = $check_in_date->diff($check_out_date);
            $nights = $interval->days;
            $total_price = $room_data['price'] * $nights;
            $user_id = $_SESSION['user_id'];

            // Insert booking
            $insert_query = "INSERT INTO bookings (user_id, room_id, check_in_date, check_out_date, total_price, status) 
                            VALUES (?, ?, ?, ?, ?, 'pending')";
            $stmt = $connect->prepare($insert_query);
            $stmt->bind_param("iissd", $user_id, $room_id, $check_in, $check_out, $total_price);

            if ($stmt->execute()) {
                echo "<script>alert('Booking successful!'); window.location.href = 'mybooking.php';</script>";
            } else {
                echo "<script>alert('Error booking the room. Please try again later.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Now - Grand Hotel</title>
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
            <span class="text-dark">Book Now</span>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="text-center">Book Room: <?php echo htmlspecialchars($room_data['name']); ?></h2>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <p><strong>Price per Night:</strong> Rs <?php echo $room_data['price']; ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($room_data['description']); ?></p>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="check_in" class="form-label">Check-in Date</label>
                                <input type="date" id="check_in" name="check_in" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="check_out" class="form-label">Check-out Date</label>
                                <input type="date" id="check_out" name="check_out" class="form-control" required>
                            </div>
                            <div id="total-price" class="mb-3">
                                <label for="total_price" class="form-label">Total Price</label>
                                <input type="text" id="total_price" class="form-control" readonly>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Confirm Booking</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector("form").addEventListener("submit", function (event) {
            const checkIn = document.querySelector("#check_in").value;
            const checkOut = document.querySelector("#check_out").value;

            if (checkIn && checkOut) {
                if (new Date(checkIn) < new Date()) {
                    alert("Check-in date cannot be in the past.");
                    event.preventDefault();
                } else if (new Date(checkIn) >= new Date(checkOut)) {
                    alert("Check-out date must be later than check-in date.");
                    event.preventDefault();
                }
            }
        });

        document.querySelector("#check_in").addEventListener("change", updateTotalPrice);
        document.querySelector("#check_out").addEventListener("change", updateTotalPrice);

        function updateTotalPrice() {
            const checkIn = document.querySelector("#check_in").value;
            const checkOut = document.querySelector("#check_out").value;
            const pricePerNight = <?php echo $room_data['price']; ?>;

            if (checkIn && checkOut) {
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                const days = (checkOutDate - checkInDate) / (1000 * 3600 * 24);

                if (days > 0) {
                    document.querySelector("#total_price").value = 'Rs ' + (pricePerNight * days);
                } else {
                    document.querySelector("#total_price").value = '';
                }
            }
        }
    </script>
</body>

</html>
