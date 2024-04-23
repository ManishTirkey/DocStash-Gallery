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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#people">People</a></li>
                    <li><a href="#about">About us</a></li>
                    <li><a href="#video">How to</a></li>

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
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="#people">People</a></li>
                    <li><a href="#about">About us</a></li>
                    <li><a href="#video">How to</a></li>
                    <li><a href="#">Feedback</a></li>
                    <li><a href="login.php" class="btn"><i class="fas fa-user"></i>Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- form -->
    <section class="footer bg-brown">
        <div class=" container  pricingrid  ">
            <div class="hero-content">
                <h1 class="hero-heading text-xxl">"Don't limit your dreams to yours resume
                    let your resume reflect your limitless potential" </h1>
                <p class="hero-text">
                </p>
                <img src="image/dos_photo5.jpg" width="400px" height="300px">

            </div>
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





    <!-- video section -->
    <section id="video" class="video-video ">
        <div class="container-sm">
            <video class="vide" controls>
                <!-- <source src="image/video.mp4 "   class="video-preview"> -->
                <source src="image/video .ogg">
            </video>
        </div>

    </section>


    <!-- about us -->
    <section id="about" class="video-video ">
        <div class="container-sm">
            <h2 class="video-heading text-xl text-center">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aperiam fugit accusantium labore minus deleniti, ab iure possimus quod excepturi aliquid ea provident laborum quibusdam! Praesentium eos quod enim? Aut, modi!
                see how it workd and get started in less the 2 mintues.
            </h2>
            <!-- <div class="video-content">
                <a href="#">
                    <img src="image/photo17.png" alt="photo6" class="video-preview" width="300px 200px">
                </a>
            </div> -->
        </div>
    </section>


    <!-- testimonials -->
    <section id="people" class="testimonials  bg-brown">
        <div class="container">

            <h3 class="testimonials-heading text-xxl">
                <u>USERS</u>
            </h3>
            <div class="testimonials-grid">

                <div class="card">

                    <div class="people-grid">
                        <img src="image/photo13.png" alt="student image">
                        <p class="card-para">"Link yourself to digital document"</p>
                    </div>
                    <div class="card-flex">
                        <button class="btn btn-primary btn-card"><a href="">Edit </a></button>

                        <button class="btn btn-primary  btn-card"><a href="">upload document</a></button>
                        <button class="btn btn-primary  btn-card"><a href="">personal information</a></button>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- pricing  
    <section class="pricing">
        <div class="container-sm">
            <h3 class="pricing-heading text-xl text-center">
                pricing
            </h3>
            <p class="pricing-subheading text-md text-center">
                start free and scale while you grow ,No hidden fees.
                Unlimites users
                for free.
            </p>
            <div class="pricing-grid">
                -pricing card1- 
                <div class="card bg-light">
                    <div class="pricing-card-header">
                        <h4 class="pricing-heading text-xl">
                            simple
                        </h4>
                        <p class="princing-card-subheading">
                            keep track your contacts,gain valuable insights analyse
                            live data and performance metrices. 
                        </p>
                        <p class="pricing-card-price"><span class="text-xl">Free</span>
                        *No credit card needed</p>
                    </div>
                    <div class="pricing-card-body">
                        <ul>
                            <li><i class="fas fa-check"></i>real-time monitoring</li>
                            <li><i class="fas fa-check"></i>schedule appointment</li>
                            <li><i class="fas fa-check"></i>Organsie delegate and keep track of task</li>
                        </ul>
                       <a href="#" class=" btn btn-primary btn-block">get started</a> 
                    </div>
                </div>

                - pricing card2-
                <div class="card bg-black">
                    <div class="pricing-card-header">
                        <h4 class="pricing-heading text-xl">
                            simple
                        </h4>
                        <p class="princing-card-subheading">
                            keep track your contacts,gain valuable insights analyse
                            live data and performance metrices. 
                        </p>
                        <p class="pricing-card-price"><span class="text-xl">Free</span>
                        *No credit card needed</p>
                    </div>
                    <div class="pricing-card-body">
                        <ul>
                            <li><i class="fas fa-check"></i>real-time monitoring</li>
                            <li><i class="fas fa-check"></i>schedule appointment</li>
                            <li><i class="fas fa-check"></i>Organsie delegate and keep track of task</li>
                        </ul>
                       <a href="#" class=" btn btn-primary btn-block">get started</a> 
                    </div>
                </div>
            </div>
            <p class="pricing-footer text-center">all prices are in usa and charged per month with applicable taxes</p>
        </div>
    </section>-->
    <!-- faq -->
    <section class="faq bg-light">
        <div class="container-sm">
            <h3 class="text-xl text-center">
                Frequently asked question
            </h3>

            <div class="faq-content">
                <div class="faq-group">
                    <div class="faq-group-header">
                        <h4 class="text-md">
                            how does the contact management feature help me keep track of clients and partner.
                        </h4>
                        <i class="fas fa-minus"></i>
                    </div>
                    <div class="faq-group-body open">
                        <p>keep track of your contact gain valuablue insights analyse live data performance metrices

                        </p>
                    </div>
                </div>


                <div class="faq-group">
                    <div class="faq-group-header">
                        <h4 class="text-md">
                            how does the contact management feature help me keep track of clients and partner.
                        </h4>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="faq-group-body ">
                        <p>keep track of your contact gain valuablue insights analyse live data performance metrices</p>
                    </div>
                </div>






                <div class="faq-group">
                    <div class="faq-group-header">
                        <h4 class="text-md">
                            how does the contact management feature help me keep track of clients and partner.
                        </h4>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="faq-group-body ">
                        <p>keep track of your contact gain valuablue insights analyse live data performance metrices
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- banner -->
    <section class="banner">
        <div class="container ">
            <div class="banner-txt">
                <h1>Join your colleagues, classmates, and friends on DOSSIER </h1>
                <a class="btn btn-primary" href="signup.php">get started</a>
            </div>
            <div class="banner-grid">
                <img src="image/photo16.png" alt="">
                <!-- <img src="image/photo17.png" alt=""> -->
                <img src="image/photo15.png" alt="">
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