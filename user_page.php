<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
    exit;
}
try {


$select_profile = $conn->prepare("SELECT * FROM `registration`  WHERE id = ?");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);


$select_personal_profile = $conn->prepare("SELECT * FROM `personal_detail`  WHERE id = ?");
$select_personal_profile->execute([$user_id]);
$fetch_personal_profile = $select_personal_profile->fetch(PDO::FETCH_ASSOC);

if ($fetch_profile !== false && $fetch_personal_profile !== false)  {
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user_page</title>
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
                    <li><a href="#">Home</a></li>
            
                    <li> <a href="user_main.php">Go Back</a></li>
                    <li><a href="personal_profile_edit.php">edit</a></li>
                    <li><a href="document.php" >upload documents </a></li>
                    <li><a class="btn " href="logout.php"><i class="fas fa-user"></i>logout</a></li>
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
                    <li><a href="#" class="active">Home</a></li>
                    <li><a href="#people">People</a></li>
                    <li><a href="#about">About us</a></li>
                    <li><a href="#video">How to</a></li>
                    <li><a href="#">Feedback</a></li>
                    <li><a href="logout.php" class="btn"><i class="fas fa-user"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- profile -->


    <div class="container">

        <div class="user-grid">

            <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
            <div class="user-about">
                <h1 class="text-xxl"><?= $fetch_profile['name']; ?></h1>

                <span>
                    <p class=" text-md  profession"><?= $fetch_personal_profile['status']; ?></p>
                </span>
                <button class="btn"><a href="#">About</a></button>
                <button><a href="user_main.php" class="btn ">Go Back</a></button>
            </div>

        </div>

    </div>


    <!-- bililography -->
    <div class="bg-brown">
        <div class="container about" id="about">
            <h3 class="head-3 text-xxl"><span>bililography</span> </h3>
            <div class="bio text-center">
                <h4><span>name:</span><?= $fetch_personal_profile['fname']; ?></h4>
                <h4><span>email:</span><?= $fetch_profile['email']; ?></h4>
                <h4><span>address:</address>:</span><?= $fetch_personal_profile['address'] ?></h4>
                <h4><span>phone:</span><?= $fetch_personal_profile['phone']; ?></h4>
                <h4><span>dob:</span><?= $fetch_personal_profile['dob']; ?></h4>
                <h4><span>gender:</span><?= $fetch_personal_profile['gender']; ?></h4>
                <h4><span>father's name:</span><?= $fetch_personal_profile['fathername']; ?></h4>
                <h4><span>mother's name:</span><?= $fetch_personal_profile['mothername']; ?></h4>
                <h4><span>hobbies:</span><?= $fetch_personal_profile['hobbies']; ?>Lorem ipsum dolor sit amet consectetur adipisicing.</h4>
            </div>

        </div>
    </div>
    <!-- pricing   -->


    <!--skill-->
    <div class="container ">
        <h3 class="head-3 text-xxl"> Skill
        </h3>
        <div id="skill_container">

            <?php
            if (isset($fetch_personal_profile['skills'])) {
                $skilldata = $fetch_personal_profile['skills'];
                //  $skilldata=$fetch_personal_profile['skills'];
                if (!empty($skilldata)) {
                    $skillshow = explode(",", $skilldata);
                    foreach ($skillshow as $skill_data) :
            ?>



                        <div class="skill bg-light text-md ">

                            <p>
                                <?php echo $skill_data; ?>
                            </p>
                        </div>

            <?php

                    endforeach;
                } else {
                    echo "No skills found.";
                }
            } else {
                echo "Skills information not available.";
            }
            ?>
        </div>
    </div>
    <!-- </div>
        </div> -->




    <!-- Education -->
    <section class="bg-brown">
        <div class=" container">
            <h1 class="head-3 text-xxl"><span> Education Qualification</span>
            </h1>
            <?php
            if (isset($fetch_personal_profile['education'])) {
                $educationdata = $fetch_personal_profile['education'];
                //  $experiencedata=$fetch_personal_profile['experience'];
                if (!empty($educationdata)) {
                    $educationshow = explode(",", $educationdata);
                    foreach ($educationshow as $education_data) :
            ?>

                        <div class="education-detail text-md">
                            <p><?php echo  $education_data; ?> </p>


                        </div>
            <?php
                    endforeach;
                } else {
                    echo "No educationfound.";
                }
            } else {
                echo "education information not available.";
            }
            ?>

        </div>

    </section>

    <!-- experience -->

    <div class="container">

        <h3 class="head-3 text-xxl"><span>Experience</span>
        </h3>
        <?php
        if (isset($fetch_personal_profile['experience'])) {
            $experiencedata = $fetch_personal_profile['experience'];
            //  $experiencedata=$fetch_personal_profile['experience'];
            if (!empty($experiencedata)) {
                $experienceshow = explode(",", $experiencedata);
                foreach ($experienceshow as $experience_data) :
        ?>
                    <div class="experience-grid text-md">

                        <p><?php echo  $experience_data; ?></p>

                    </div>

        <?php
                endforeach;
            } else {
                echo "No experience found.";
            }
        } else {
            echo "Experience information not available.";
        }
        ?>

    </div>




    <!--project -->
    <section class="bg-brown">
        <div class="container">

            <h3 class="head-3 text-xxl"><span> Recent Projects</span>
            </h3>
            <?php
        if (isset($fetch_personal_profile['project_descript'])) {
            $project_descriptdata = $fetch_personal_profile['project_descript'];
            //  $experiencedata=$fetch_personal_profile['experience'];
            if (!empty($project_descriptdata)) {
                $project_descriptshow = explode(",", $project_descriptdata);
                foreach ($project_descriptshow as $project_descript_data) :
        ?>
         

            <div class="pricing-grid">
                <!-- -pricing card1-  -->
                <div class="card bg-dark">
                    <h4 class="text-lg">
                       About projects :
                    </h4>
                    <p class="pricing-card-subheading text-md">
                     <span ><?php echo  $project_descript_data; ?></span>
                    </p>

            


                </div>


            </div>
            <?php
                endforeach;
            } else {
                echo "No project found.";
            }
        } else {
            echo "project information not available.";
        }
        ?>



        </div>

    </section>
<!--  -->


    <!-- <section class="container  bg-light">
    <div class="personal-btn "> -->

    <!-- <a href="personal_profile_edit.php" class="btn btn-primary">edit</a>
      <a href="doc_upload.php" class="btn btn-dark">upload documents </a>
        <a href="logout.php" class="btn btn-primary">logout</a> -->
    <!-- </div>
    </section> -->
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
<?php
    } else {
        // Handle case where no data is found
        echo "Enter your personal information first.";
    }
} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}
?>