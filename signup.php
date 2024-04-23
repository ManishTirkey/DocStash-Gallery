<?php
include 'config.php';

$message = array(); // Initialize an empty array for error/success messages

if(isset($_POST['submit'])) {
    // Sanitize and validate form input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    $cpass = trim($_POST['cpass']);
    $user_type = trim($_POST['user_type']);
    $image = $_FILES['image'];

    // Validate Name
    if(empty($name)) {
        $message[] = 'Name is required';
    }

    // Validate Email
    if(empty($email)) {
        $message[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Invalid email format';
    }

    // Validate Password
    if(empty($pass)) {
        $message[] = 'Password is required';
    } elseif(strlen($pass) < 6) {
        $message[] = 'Password must be at least 6 characters long';
    }

    // Validate Confirm Password
    if(empty($cpass)) {
        $message[] = 'Confirm password is required';
    } elseif($pass != $cpass) {
        $message[] = 'Confirm password does not match';
    }

    // Validate User Type
    if(empty($user_type)) {
        $message[] = 'User type is required';
    }

    // Validate Image
    if(empty($image['name'])) {
        $message[] = 'Image is required';
    } elseif($image['size'] > 2000000) {
        $message[] = 'Image size is too large';
    } elseif(!in_array($image['type'], array('image/jpeg', 'image/png'))) {
        $message[] = 'Invalid image format. Only JPEG and PNG are allowed';
    }

    // If there are no errors, proceed with the registration process
    if(empty($message)) {
        // Hash the password
        $hashedPassword = md5($pass);
        
        // Check if the email already exists
        $select = $conn->prepare("SELECT * FROM `registration` WHERE email=?");
        $select->execute([$email]);
        
        if($select->rowCount() > 0) {
            $message[] = 'User already exists';
        } else {
            // Insert user data into the database
            $insert = $conn->prepare("INSERT INTO `registration` (name, email, password, user_type, image) VALUES (?, ?, ?, ?, ?)");
            $insert->execute([$name, $email, $hashedPassword, $user_type, $image['name']]);
            
            // Move the uploaded image to the destination folder
            move_uploaded_file($image['tmp_name'], 'uploaded_img/' . $image['name']);
            
            $message[] = 'Registered successfully!';
            header('Location: login.php');
            exit(); // Stop execution after redirection
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
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet"/>
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
            <button  class="hamburger-button">
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
                <div class="hamburger-line"></div>
            </button>
            <div class="mobile-menu ">
                <ul>
                    <li><a href="index.html">Home</a></li>
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
                <header>Create new account</header>
                <?php 
                 if (isset($message) && is_array($message)) {
               foreach($message as $message){
                    echo '
                   <div class="message">
                        <span>'.$message.'</span>
                         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                    </div>';
    }
}
?>
                <form action="signup.php" method="post" enctype="multipart/form-data">
                    <div class="field  ">
                        <input type="text" class="input" placeholder="UserName" name="name" required>
                    </div>
                    <div class="field  ">
                        <input type="email" class="input" placeholder="Email" name="email" required>
                    </div>
                    <div class="field ">
                        <input type="password" class="input" placeholder="password" name="pass">

                    </div>
                    <div class="field">
                    <input type="password" class="input" placeholder=" confirm password" name="cpass">
                    </div>

                    <div class="field">
                    <select id="user_id" name="user_type" >
                    <option value="user">user</option>
                    <option value="admin">admin</option>
                    </select>
                    </div>

                    <div class="field">
                        <input type="file" name="image" class="imagefile" accept="image/jpg, image/png, image/jpeg" required>
                    </div>
                     
                    <div class="form-link">
                        <span>Already have an account?<a href="login.php" class="signup-link">Login</a></span>
              
                    </div>
                    <input type="submit" name="submit" value="SignUp" class="field button">
                
                    
                </form>
                
            </div>
            
        </div>
    
      
     
    
    </section>
        
       
           

         <!-- footer -->
   <footer class="footer bg-black">
    <div class="container">
        <div class="footer-grid">
            <div>
                <a href="index.html">
                    <img src="image/logo-white.png" alt="logo">
                </a>
                <div class="card">
                    <h4>subscribe to newsletter</h4>
                    <p class="text-sm">
                        subscribe now to receive tips on how to take your business to the next level.
                    </p>
                    <form >
                        <input type="email" id="email" placeholder="enter your email"/>
                        <button type="submit" class="btn btn-primary btn-block">subscribe</button>
                    </form>
                </div>
                <i class="fab fa-linkedin"></i>
                <i class="fab fa-twitter"></i>
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