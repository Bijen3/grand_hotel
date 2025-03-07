<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRAND HOTEL - HOMEPAGE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-nav {
            flex-grow: 1;
            justify-content: flex-end;
        }

        .next:hover {
            color: orangered;
        }

        .nav-link {
            font-size: 17px;
        }

        .btn-custom {
            background-color: rgb(226, 235, 239);
            border: none;
        }

        .btn-custom:hover {
            background-color: rgb(77, 150, 222);
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-lg-3 py-lg-2 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand h-font me-5 fw-bold fs-3"
                href="index.php"><?php echo $settings_r['site_title']; ?></a>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link next me-2" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link next me-2" href="rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link next me-2" href="facilities.php">Facilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link next me-2" href="contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link next" href="about.php">About</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <?php
                    if (!empty($_SESSION["user"])) {
                        // If user is logged in, display profile icon and name in a dropdown
                        echo '<li class="nav-item dropdown">';
                        echo '  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                        echo '    <i class="fas fa-user-circle"></i> ' . htmlspecialchars($_SESSION["user_name"]);
                        echo '  </a>';
                        echo '  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                        echo '    <li><a class="dropdown-item" href="#">Profile</a></li>';
                        echo '    <li><a class="dropdown-item" href="logout.php">Logout</a></li>';
                        echo '  </ul>';
                        echo '</li>';
                    } else {
                        // If user is not logged in, display "Log In" and "Register" buttons
                        echo '<li class="nav-item"><button class="btn btn-custom ms-3" onclick="window.location.href=\'signin.php\'">Log In</button></li>';
                        echo '<li class="nav-item"><button class="btn btn-custom ms-3" onclick="window.location.href=\'register.php\'">Register</button></li>';
                    }
                    ?>
                </ul>


            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>