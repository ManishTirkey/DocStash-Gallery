<?php
include 'config.php';
session_start();

$message = array(); // Initialize an empty array for error/success messages

if (isset($_POST['submit'])) {
    // Sanitize and validate form input
    $email = trim($_POST['email']);
    $pass = md5($_POST['pass']);

    // Check if email and password are provided
    if (empty($email) || empty($pass)) {
        $message[] = 'Please enter both email and password';
    } else {
        // Prepare and execute SQL statement to fetch user data
        $select = $conn->prepare("SELECT * FROM `registration` WHERE email=? AND password = ?");
        $select->execute([$email, $pass]);
        $row = $select->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and password matches
        if ($select->rowCount() > 0) {
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_id'] = $row['id'];
                header('location: admin_main.php');
                exit();
            } elseif ($row['user_type'] == 'user') {
                if (isset($row['status']) && $row['status'] === 'active') {
                    $_SESSION['user_id'] = $row['id'];
                    header('location: user_main.php');
                    exit();
                } else {
                    $message[] = "Your account is inactive.";
                }
            }
        } else {
            $message[] = 'Incorrect email or password';
        }
    }
}
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
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="image/logo.jpg" alt="logo"> </a>
            </div>
            <div class="main-menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">People</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Contact</a></li>

                    <li><a class="btn " href="login.php"><i class="fas fa-user"></i>Login</a></li>
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">People</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Feedback</a></li>
                    <li><a class="btn " href="login.php"><i class="fas fa-user"></i>Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class=" containerform ">

        <div class="form ">
            <div class="form-content">
                <header>Login</header>
                <?php
                if (isset($message) && is_array($message)) {
                    foreach ($message as $message) {
                        echo '
                            <div class="message">
                                 <span>' . $message . '</span>
                                  <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                             </div>';
                    }
                }
                ?>
                <form action="login.php" method="post" enctype="multipart/form-data">
                    <div class="field  ">
                        <input type="email" class="input" placeholder="Email" name="email">
                    </div>
                    <div class="field ">
                        <input type="password" class="password" placeholder="password" name="pass" required>
                    </div>
                    <div class="form-link">
                        <a href="forget_password.php" class="forgot-pass">forgot password?</a>

                    </div>
                    <input type="submit" name="submit" value="login" class="field button">


                </form>

            </div>
            <div class="line"></div>
            <div class="media-option ">
                <span><a href="signup.php">NEW TO DOSSIER ? SIGNUP</a></span>
            </div>
        </div>




    </section>




    <!-- footer -->
    <footer class="footer bg-black">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="index.php">
                        <img src="image/logo.jpg" alt="logo">
                    </a>
                </div>
                <div>
                    <h4>company
                        <ul>
                            <li><a href="#">about us</a></li>
                            <li><a href="#">process</a></li>
                            <li><a href="#">join </a></li>
                        </ul>
                    </h4>
                </div>
                <div>
                    <h4>resoure</h4>
                    <ul>
                        <li><a href="#">News</a></li>
                        <li><a href="#">research</a></li>
                        <li><a href="#">recent projects</a></li>
                    </ul>
                </div>
                <div>
                    <h4>contacts</h4>
                    <ul>
                        <li><a href="#">hello@growthapp.com</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>

</html>