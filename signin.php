<?php
session_start();
$hostname = "localhost";
$database = "grandhotel";
$username = "root";
$password = "";

// Establish a connection to the database
$connect = new mysqli($hostname, $username, $password, $database);

// Check if the connection was successful
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email and password are set to prevent undefined index errors
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($email) || empty($password)) {
        echo "<script>alert('Email and password are required.');</script>";
    } else {
        // Prepare the query to fetch user data
        $query = "SELECT id, name, email, password FROM customer WHERE email = ?";

        if ($stmt = $connect->prepare($query)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($user_id, $user_name, $user_email, $user_password);
                $stmt->fetch();

                if (password_verify($password, $user_password)) {
                    // Password is correct, start session securely
                    session_regenerate_id(true); // Prevent session fixation
                    $_SESSION["user"] = $user_email;
                    $_SESSION["user_id"] = $user_id;
                    $_SESSION["user_name"] = $user_name;
                    
                    header("Location: index.php");
                    exit();
                } else {
                    echo "<script>alert('Invalid email or password.');</script>";
                }
            } else {
                echo "<script>alert('Invalid email or password.');</script>";
            }
            $stmt->close();
        }
    }
}
$connect->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Grand Hotel</title>
    <?php require('inc/links.php'); ?>
    <style>
        .login-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form method="POST">
            <h4 class="bg-dark text-white py-3">USER LOGIN PANEL</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input name="email" required type="email" class="form-control shadow-none text-center" placeholder="Email Address">
                </div>
                <div class="mb-4">
                    <input name="password" required type="password" class="form-control shadow-none text-center" placeholder="Password">
                </div>
                <button type="submit" class="btn text-white custom-bg shadow-none">LOG IN</button>
            </div>
        </form>
        <p class="text-center text-dark">Don't have an account? <a href="register.php" class="text-warning text-decoration-none">Register</a></p>
    </div>
</body>
</html>
