<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    try {
        $fname = $_POST['fname'];
        $fname = htmlspecialchars($fname, ENT_QUOTES, 'UTF-8');
        $phone = $_POST['phone'];
        $phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
        $dob = $_POST['dob'];
        $dob = htmlspecialchars($dob, ENT_QUOTES, 'UTF-8');
        $gender = $_POST['gender'];
        $gender = htmlspecialchars($gender, ENT_QUOTES, 'UTF-8');
        $address = $_POST['address'];
        $address = htmlspecialchars($address, ENT_QUOTES, 'UTF-8');
        $country = $_POST['country'];
        $country = htmlspecialchars($country, ENT_QUOTES, 'UTF-8');
        $fathername = $_POST['fathername'];
        $fathername = htmlspecialchars($fathername, ENT_QUOTES, 'UTF-8');
        $mothername = $_POST['mothername'];
        $mothername = htmlspecialchars($mothername, ENT_QUOTES, 'UTF-8');
        $hobbies = $_POST['hobbies'];
        $hobbies = htmlspecialchars($hobbies, ENT_QUOTES, 'UTF-8');
        $status = $_POST['status'];
        $status = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');
        $skills = $_POST['skills'];
        $skills = htmlspecialchars($skills, ENT_QUOTES, 'UTF-8');
        $experience = $_POST['experience'];
        $experience = htmlspecialchars($experience, ENT_QUOTES, 'UTF-8');
        $education = $_POST['education'];
        $education = htmlspecialchars($education, ENT_QUOTES, 'UTF-8');
        $project_descript = $_POST['project_descript'];
        $project_descript = htmlspecialchars($project_descript, ENT_QUOTES, 'UTF-8');


        $update_personal = $conn->prepare("UPDATE `personal_detail` SET fname = ?, phone = ?, dob = ?, gender = ?, address = ?, country = ?, fathername = ?, mothername = ?, hobbies = ?, status = ?, skills = ?, experience = ?, education = ?, project_descript = ? WHERE id = ?");
        $update_personal->execute([$fname, $phone, $dob, $gender, $address, $country, $fathername, $mothername, $hobbies, $status, $skills, $experience, $education, $project_descript, $user_id]);

        // Check if update was successful
        if ($update_personal->rowCount() > 0) {
            $message = "Profile updated successfully!";
        } else {
            $message = "No changes were made to the profile.";
        }
    } catch (PDOException $e) {
        // Handle database error
        $message = "Error: " . $e->getMessage();
    }
}

// Fetch updated personal data again after update
$select_personal = $conn->prepare("SELECT * FROM `personal_detail`  WHERE id = ?");
$select_personal->execute([$user_id]);
$fetch_personal = $select_personal->fetch(PDO::FETCH_ASSOC);

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
    <!-- symbol -->
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

                    <li><a href="#people">View</a></li>
                    <li><a href="#about">Edit Details</a></li>
                    <li><a class="btn " href="logout.php"><i class="fas fa-user"></i>Login</a></li>
                </ul>
            </div>
            <!-- hamburger button -->
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

    <section class="container">
        <h2 class="title text-center"><span> Update your profile</span></h2>
        <?php
        if (isset($message) && is_array($message)) {
            foreach ($message as $message) {
                echo '<div class="message"><span>' . $message . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
            }
        }
        ?>

        <?php
        $select_personal = $conn->prepare("SELECT * FROM `personal_detail`  WHERE id = ?");
        $select_personal->execute([$user_id]);
        $fetch_personal = $select_personal->fetch(PDO::FETCH_ASSOC);
        ?>
        <section class="container">

            <form action="personal_profile_edit.php" method="post" enctype="multipart/form-data" class="form-personal">

                <label>Full Name:</label>
                <input type="text" class="input" placeholder="Enter your full name" pattern="[a-zA-Z\s]{1,30}" name="fname" value="<?= $fetch_personal['fname']; ?>"><br>

                <label>Phone:</label>
                <input type="tel" class="input" placeholder="Enter your phone number" name="phone" value="<?= $fetch_personal['phone']; ?>"><br>

                <label>Date of Birth:</label>
                <input type="date" class="input" name="dob" value="<?= $fetch_personal['dob']; ?>"><br>

                <label>Gender:</label>
                <input type="radio" id="male" name="gender" value="male" <?php if ($fetch_personal['gender'] == 'male') echo 'checked'; ?>>
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female" <?php if ($fetch_personal['gender'] == 'female') echo 'checked'; ?>>
                <label for="female">Female</label><br>


                <label>Address:</label>
                <textarea placeholder="Enter your address" rows="3" cols="30" name="address"><?= $fetch_personal['address']; ?></textarea><br>

                <label>Country:</label>
                <input type="text" class="input" placeholder="Enter your country name" name="country" value="<?= $fetch_personal['country']; ?>"><br>

                <label>Father's Name:</label>
                <input type="text" class="input" placeholder="Enter your father's name" pattern="[a-zA-Z\s]{1,25}" name="fathername" value="<?= $fetch_personal['fathername']; ?>"><br>

                <label>Mother's Name:</label>
                <input type="text" class="input" placeholder="Enter your mother's name" pattern="[a-zA-Z\s]{1,25}" name="mothername" value="<?= $fetch_personal['mothername']; ?>"><br>

                <label>Hobbies:</label>
                <textarea name="hobbies" placeholder="Enter your hobbies" rows="3" cols="30"><?= $fetch_personal['hobbies']; ?></textarea><br>

                <label>Current Status:</label>
                <textarea name="status" placeholder="e.g., I am an assistant manager at XYZ company" rows="3" cols="30"><?= $fetch_personal['status']; ?></textarea><br>

                <hr>

                <h1 class="personal_title">Skills:</h1>
                <label>Skill :</label>
                <textarea name="skills" placeholder="Enter your skill" rows="3" cols="30"><?= $fetch_personal['skills']; ?></textarea><br>

                <hr>

                <h1 class="personal_title">Experience:</h1>
                <label>Experience :</label>
                <textarea name="experience" placeholder="Enter your experience" rows="3" cols="30"><?= $fetch_personal['experience']; ?></textarea><br>

                <h1 class="personal_title">Education Qualification:</h1>
                <label>Education Detail :</label>
                <input type="text" class="input" placeholder="Enter your education detail" name="education" value="<?= $fetch_personal['education']; ?>"><br>

                <h1 class="personal_title">Recent Projects:</h1>
                <label>Project Description:</label>
                <textarea name="project_descript" placeholder="Enter your project description" rows="3" cols="30"><?= $fetch_personal['project_descript']; ?></textarea><br>


                <input type="submit" name="update" value="Update" class="btn btn-primary">
                <a href="user_main.php" class="btn btn-dark">Go Back</a>
            </form>
        </section>

    </section>

    <script src="js/main.js"></script>
</body>

</html>