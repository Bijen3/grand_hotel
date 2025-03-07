<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grandhotel";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['cpass']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required.');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.');</script>";
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $check_email = "SELECT email FROM customer WHERE email = ?";
        $stmt = $conn->prepare($check_email);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Email already registered.');</script>";
        } else {
            // Insert user into database
            $sql = "INSERT INTO customer (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful! Redirecting...');</script>";
                header("refresh:2; url=signin.php");
                exit();
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Grand Hotel</title>
    <?php require('inc/links.php'); ?>
    <style>
        .register-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="register-form text-center rounded bg-white shadow overflow-hidden">
        <form method="POST">
            <h4 class="bg-dark text-white py-3">USER REGISTER PANEL</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input name="name" required type="text" class="form-control shadow-none text-center" placeholder="Full Name">
                </div>
                <div class="mb-3">
                    <input name="email" required type="email" class="form-control shadow-none text-center" placeholder="Email Address">
                </div>
                <div class="mb-4">
                    <input name="password" required type="password" class="form-control shadow-none text-center" placeholder="Password">
                </div>
                <div class="mb-4">
                    <input name="cpass" required type="password" class="form-control shadow-none text-center" placeholder="Confirm Password">
                </div>
                <button name="register" type="submit" class="btn text-white custom-bg shadow-none">REGISTER</button>
            </div>
        </form>
        <p class="text-center text-dark">Already have an account? <a href="signin.php" class="text-warning text-decoration-none">Log In</a></p>
    </div>
</body>
</html>