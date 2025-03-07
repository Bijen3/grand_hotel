<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminSignin();

// Function to Delete Customer
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete related bookings first
    $q1 = "DELETE FROM bookings WHERE user_id=?";
    $stmt1 = $con->prepare($q1);
    $stmt1->bind_param("i", $id);
    $stmt1->execute();

    // Now delete the customer
    $q2 = "DELETE FROM customer WHERE id=?";
    $stmt2 = $con->prepare($q2);
    $stmt2->bind_param("i", $id);

    if ($stmt2->execute()) {
        alert('success', 'Customer deleted successfully!');
    } else {
        alert('error', 'Deletion failed!');
    }
}

// Function to Add Customer
if (isset($_POST['add_customer'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $q = "INSERT INTO customer (name, email, password, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $con->prepare($q);
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        alert('success', 'Customer added successfully!');
    } else {
        alert('error', 'Failed to add customer!');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Users</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">USERS</h3>

                <!-- Add Customer Form -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" name="add_customer" class="btn btn-success">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Customer Table -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="table-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q = "SELECT * FROM customer ORDER BY id DESC";
                                    $data = mysqli_query($con, $q);
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        echo <<<row
                                            <tr>
                                                <td>$i</td>
                                                <td>$row[name]</td>
                                                <td>$row[email]</td>
                                                <td>$row[created_at]</td>
                                                <td>
                                                    <a href="?delete=$row[id]" class="btn btn-danger btn-sm rounded-pill">Delete</a>
                                                </td>
                                            </tr>
                                        row;
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div> <!-- col -->
        </div> <!-- row -->
    </div> <!-- container -->

    <?php require('inc/scripts.php'); ?>

    <!-- <script>
        // Auto-dismiss alerts after 3-4 seconds
        setTimeout(function() {
            document.querySelectorAll('.custom_alert').forEach(alert => {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500);
            });
        }, 3500);
    </script> -->

</body>
</html>
