<!DOCTYPE html>
<html>

<head>
    <title>Document Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <!-- symol -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/document.css">
    <!-- title -->
    <link rel="shortcut icon" href="image/favi.ico" type="image/x-icon">

</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="image/logo.jpg" alt="logo"> </a>
            </div>
            <div class="main-menu">
                <ul>
                    <li><a href="user_main.php">Home</a></li>

                    <li> <a href="user_main.php">Go Back</a></li>

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
                    <li><a href="user_main" class="active">Home</a></li>
                    <li><a href="#people">People</a></li>
                    <li><a href="#about">About us</a></li>
                    <li><a href="#video">How to</a></li>
                    <li><a href="#">Feedback</a></li>
                    <li><a href="logout.php" class="btn"><i class="fas fa-user"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container doc_container">

        <div class="account-list">
            <h1 class="title text-center"><span>Document</span></h1>

            <form action="upload.php" method="post" enctype="multipart/form-data" id="uploadForm">
                <div class="field  ">
                    <input type="file" name="file" required>
                    <?php
                    session_start();
                    $user_id = $_SESSION['user_id'];
                    echo "<input type='hidden' name='auth_id' value=$user_id>";
                    ?>

                    <div class="btns">
                        <a><input type="submit" class="submit btn btn-primary" value="Upload"></a>
                        <a href="gallery_loading_skeleton.php" class="btn btn-primary">Gallery</a>
                    </div>

                </div>
            </form>

            <br>
            <div class="doc">
                <h3 class="text-lg">Uploaded Documents</h3>
                <ul>
                    <?php

                    $user_id = $_SESSION['user_id'];
                    if (!isset($user_id)) {
                        header('location:login.php');
                    }

                    $conn = mysqli_connect("localhost", "root", "", "dossier");

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $result = $conn->query("SELECT * FROM files WHERE AUTH_ID = $user_id");

                    if ($result->num_rows > 0) {

                        while ($row = $result->fetch_assoc()) {
                            echo "<li>{$row['filename']} ({$row['filesize']} bytes)</li>";
                        }
                    } else {
                        echo "<div id='response' style='color:red;'>No documents uploaded yet.</div>";
                    }
                    $conn->close();
                    ?>



                </ul>
            </div>
        </div>
    </div>


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

    <!-- <script src="js/upload.js"></script> -->
</body>

</html>