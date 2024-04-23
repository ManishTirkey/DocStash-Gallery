<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        $fname = $_POST['fname'];
        $phone = $_POST['phone'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $country = $_POST['country'];
        $fathername = $_POST['fathername'];
        $mothername = $_POST['mothername'];
        $hobbies = $_POST['hobbies'];
        $status = $_POST['status'];


        $skills = json_encode($_POST['skills']);
        $experience = json_encode($_POST['experience']);
        $education = json_encode($_POST['education']);



        $project_descript = $_POST['project_descript'];
        $pin = $_POST['pin'];


        $con = mysqli_connect("localhost", "root", "", "dossier");

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $result = $con->query("SELECT * FROM personal_detail WHERE id = $user_id");
        echo "$result->num_rows";


        if ($result->num_rows == 0) {
            echo "inserting data";

            $sql = "INSERT INTO personal_detail (id, fname, phone, dob, gender, address, country, fathername, mothername, hobbies, status, skills, experience, education,  project_descript,pin) 
                VALUES (:id, :fname, :phone, :dob, :gender,:address, :country, :fathername, :mothername, :hobbies, :status, :skills, :experience, :education,  :project_descript, :pin)";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':id', $user_id);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':country', $country);
            $stmt->bindParam(':fathername', $fathername);
            $stmt->bindParam(':mothername', $mothername);
            $stmt->bindParam(':hobbies', $hobbies);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':skills', $skills);
            $stmt->bindParam(':experience', $experience);
            $stmt->bindParam(':education', $education);

            $stmt->bindParam(':project_descript', $project_descript);
            $stmt->bindParam(':pin', $pin);

            $stmt->execute();
        } else {

            $update_personal = $conn->prepare("UPDATE `personal_detail` SET fname = ?, phone = ?, dob = ?, gender = ?, address = ?, country = ?, fathername = ?, mothername = ?, hobbies = ?, status = ?, skills = ?, experience = ?, education = ?, project_descript = ? WHERE id = ?");
            $update_personal->execute([$fname, $phone, $dob, $gender, $address, $country, $fathername, $mothername, $hobbies, $status, $skills, $experience, $education, $project_descript, $user_id]);
        }
        header("Location: user_page.php");
        exit();
    } catch (PDOException $e) {

        echo "Error: " . $e->getMessage();
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

    <section class="container">
        <h2 class=" title text-center"><span>Personal information</span></h2>

        <form action="personal_profile.php" method="post" enctype="multipart/form-data" class="form-personal">
            <h1 class="personal_title">Biography:</h1>
            <label>Full Name:</label>
            <input type="text" class="input" placeholder="Enter your full name" pattern="[a-zA-Z\s]{1,25}" name="fname" value=""><br>

            <label>Phone:</label>
            <input type="tel" class="input" placeholder="Enter your phone number" name="phone" value=""><br>

            <label>Date of Birth:</label>
            <input type="date" class="input" name="dob" value=""><br>

            <label>Gender:</label>
            <input type="radio" id="male" name="gender" value="male">
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label><br>

            <label>Address:</label>
            <textarea name="address" placeholder="Enter your address" rows="3" cols="30"></textarea><br>

            <label>State:</label>
            <input type="text" class="input" placeholder="Enter your state name" name="state" value=""><br>

            <label>Country:</label>
            <input type="text" class="input" placeholder="Enter your country name" name="country" value=""><br>

            <label>Father's Name:</label>
            <input type="text" class="input" placeholder="Enter your father's name" pattern="[a-zA-Z\s]{1,25}" name="fathername" value=""><br>

            <label>Mother's Name:</label>
            <input type="text" class="input" placeholder="Enter your mother's name" pattern="[a-zA-Z\s]{1,25}" name="mothername" value=""><br>

            <label>Hobbies:</label>
            <textarea name="hobbies" placeholder="Enter your hobbies" rows="3" cols="30"></textarea><br>

            <label>Current Status:</label>
            <textarea name="status" placeholder="e.g., I am an assistant manager at XYZ company" rows="3" cols="30"></textarea><br>

            <hr>

            <h1 class="personal_title">Skills:</h1>

            <label>Skill :</label>
            <textarea name="skills" placeholder="Enter your skill" rows="3" cols="30"></textarea><br>



            <hr>

            <h1 class="personal_title">Experience:</h1>

            <label>Experience :</label>
            <textarea name="experience" placeholder="Enter your experience" rows="3" cols="30"></textarea><br>


            <h1 class="personal_title">Education Qualification:</h1>

            <label>Education Detail :</label>
            <input type="text" class="input" placeholder="Enter your education detail" name="education" value=""><br>




            <h1 class="personal_title">Recent Projects:</h1>

            <label>Project Description:</label>
            <textarea name="project_descript" placeholder="Enter your project description" rows="3" cols="30"></textarea><br>

            <h1 class="personal_title">Create six digit pin:</h1>
            <input type="tel" class="input" placeholder="create six digit pin " pattern="[0-9]{6}" maxlength="6" name="pin" value=""><br>



            <input type="submit" name="personal" value="Save" class="btn btn-primary">

            <button type="reset" class="btn" value="Reset">Reset</button>
            <button> <a href="user_main.php" class="btn btn-dark">Go Back</a></button>
        </form>
    </section>

    <script src="js/main.js"></script>

</body>

</html>