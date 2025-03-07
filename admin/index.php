<?php 
    require('inc/essentials.php');
    require('inc/db_config.php');

    session_start();
    if((isset($_SESSION['adminSignin']) && $_SESSION['adminSignin'] == true)){
        redirect('dashboard.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <?php require('inc/links.php') ?>
    <style>
        .login-form{
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
            <h4 class="bg-dark text-white py-3">ADMIN LOGIN PANEL</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input name="admin_name" required type="text" class="form-control shadow-none text-center" placeholder="Admin Name">
                </div>
                <div class="mb-4">
                    <input name="admin_pass" required type="password" class="form-control shadow-none text-center" placeholder="Password">
                </div> 
                <button name="signin" type="submit" class="btn text-white custom-bg shadow-none">SIGN IN</button> 
            </div>
        </form>
    </div>

    <?php
        
        if(isset($_POST['signin']))
        {
            $frm_data = filteration($_POST); //filteration function called and filter and store to frm_data
            
            $query = "SELECT * FROM `admin_cred` WHERE `admin_name`=? AND `admin_pass`=?"; //query for prepared statement
            $values = [$frm_data['admin_name'], $frm_data['admin_pass']]; //array with 2 values
            
            $res = select($query, $values, "ss"); //select function called with 3 values passed
            
            if($res -> num_rows == 1){
                $row = mysqli_fetch_assoc($res); 
                $_SESSION['adminSignin'] = true;
                $_SESSION['adminId'] = $row['sr_no'];
                redirect('dashboard.php');
            }
            else{
                alert('error', 'Sign In failed - Invalid Credentials!!!');
            }
        }

    ?>

    <?php require('inc/scripts.php') ?>
</body>
</html>