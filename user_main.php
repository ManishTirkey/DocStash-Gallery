<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}


$select_profile = $conn->prepare("SELECT * FROM `registration`  WHERE id = ?");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Growth app</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <!-- symol -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- title -->
    <link rel="shortcut icon" href="image/favi.ico" type="image/x-icon">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="image/logo.jpg" alt="logo"> </a>
            </div>
            <div class="main-menu">
                <ul>

                    <li><a href="user_page.php">view</a></li>
                    <li><a href="user_profile_update.php">edit details</a></li>

                    <li><a class="btn " href="logout.php"><i class="fas fa-user"></i>Logout</a></li>
                </ul>
            </div>
            <!-- hambuger button -->
            <button class="hamburger-button">
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
            </button>
            <div class="mobile-menu ">
                <ul>
                    <li><a href="index.html" class="active">Home</a></li>
                    <li><a href="#people">People</a></li>
                    <li><a href="#about">About us</a></li>
                    <li><a href="#video">How to</a></li>
                    <li><a href="#">Feedback</a></li>
                    <li><a href="login.php" class="btn"><i class="fas fa-user"></i>Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- profile -->
    <section class="container ">
        <h1 class="title text-center"><span>WELCOME</span></h1>
        <div class="container-profile">

            <div class="profile">
                <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
                <h3 class="name text-center"><?= $fetch_profile['name']; ?></h3>
                <a href="personal_profile.php" class="btn btn-dark btn-block">personal information</a>
                <a href="gallery_loading_skeleton.php" class="btn btn-dark btn-block" style="margin-top:.3em;">Gallery</a>


                <div class="flex-btn">

                    <a href="user_profile_update.php" class="btn btn-primary">edit</a>
                    <a href="user_page.php" class="btn btn-dark">view</a>
                    <a href="logout.php" class="btn btn-primary">logout</a>
                </div>

            </div>

        </div>
    </section>


    <!-- footer -->
    <footer class="footer bg-black">
        <div class="container">
            <div class="text-center foot-grid">
                <div>
                    <img src="image/logo.jpg" alt="logo">
                    <a href="#">edit</a>
                    <a href="#">logout</a>
                    <a href="#">join </a>

                </div>

            </div>
        </div>
    </footer>



    <script src="js/main.js"></script>
</body>

</html>