<?php
    require('inc/essentials.php');
    require('inc/db_config.php');
    adminSignin();
    
    if(isset($_GET['status'])){
        $frm_data = filteration($_GET);
        if($frm_data['status'] == 'all'){
            $q = "UPDATE `bookings` SET `status`=?";
            $values = ['confirmed'];
            if(update($q, $values, 's')){
                alert('success', 'Marked all as confirmed!');
            } else {
                alert('error', 'Operation failed!');
            }
        } else {
            $q = "UPDATE `bookings` SET `status`=? WHERE `id`=?";
            $values = ['confirmed', $frm_data['status']];
            if(update($q, $values, 'si')){
                alert('success', 'Booking marked as confirmed!');
            } else {
                alert('error', 'Operation failed!');
            }
        }
    }

    if(isset($_GET['del'])){
        $frm_data = filteration($_GET);
        if($frm_data['del'] == 'all'){
            $q = "DELETE FROM `bookings`";            
            if(mysqli_query($con, $q)){
                alert('success', 'All bookings deleted!');
            } else {
                alert('error', 'Operation failed!');
            }
        } else {
            $q = "DELETE FROM `bookings` WHERE `id`=?";
            $values = [$frm_data['del']];            
            if(delete_item($q, $values, 'i')){
                alert('success', 'Booking deleted!');
            } else {
                alert('error', 'Operation failed!');
            }
        }        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Bookings</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">BOOKINGS</h3>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <a href="?status=all" class="btn btn-dark rounded-pill shadow-none btn-sm"><i class="bi bi-check-all"></i> Mark all confirmed</a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm"><i class="bi bi-trash"></i> Delete all</a>
                        </div>

                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="table-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Room ID</th>
                                        <th scope="col">Check-in Date</th>
                                        <th scope="col">Check-out Date</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $q = "SELECT * FROM `bookings` ORDER BY `id` DESC";
                                        $data = mysqli_query($con, $q);
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($data)){
                                            $status = '';
                                            if($row['status'] != 'confirmed'){
                                                $status = "<a href='?status=$row[id]' class='btn btn-sm rounded-pill btn-primary'>Mark as confirmed</a> <br>";
                                            }
                                            $status .= "<a href='?del=$row[id]' class='btn btn-sm rounded-pill btn-danger mt-2'>Delete</a>";
                                            echo <<<booking
                                                <tr>
                                                    <td>$i</td>
                                                    <td>$row[user_id]</td>
                                                    <td>$row[room_id]</td>
                                                    <td>$row[check_in_date]</td>
                                                    <td>$row[check_out_date]</td>
                                                    <td>Rs $row[total_price]</td>
                                                    <td>$row[status]</td>
                                                    <td>$status</td>
                                                </tr>
                                            booking;
                                            $i++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>

</body>
</html>
