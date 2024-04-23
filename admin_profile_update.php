<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
if(!isset($user_id)){
    header('location:login.php');
}

// Check if the user is admin
$is_admin = false;
if(isset($_SESSION['admin_id'])){
    $is_admin = true;
}

if(isset($_POST['update'])){
    $name=$_POST['name'];
    $name=htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
   
    $email=$_POST['email'];
    $email=htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

    $update_profile = $conn->prepare("UPDATE `registration` SET name = ? ,email = ? WHERE id = ?");
    $update_profile->execute([$name,$email,$user_id]);

    $old_image=$_POST['old_image'];
    $image=$_FILES['image']['name'];
    $image_tmp_name=$_FILES['image']['tmp_name'];
    $image_size=$_FILES['image']['size'];
    $image_folder='uploaded_img/'.$image;

    if(!empty($image))
    {
        if($image_size > 2000000){
            $message[]='Image size is too large';
        }else{
            $update_image = $conn->prepare("UPDATE `registration` SET image =? WHERE id = ?");
            $update_image->execute([$image ,$user_id]);

            if($update_image){
                move_uploaded_file($image_tmp_name,$image_folder);
                unlink('uploaded_img/'.$old_image);
                $message[] = 'Image has been updated';
            }
        }
    }

    $old_pass = $_POST['old_pass'];
    $previous_pass = md5($_POST['previous_pass']);
    $previous_pass = htmlspecialchars($previous_pass, ENT_QUOTES, 'UTF-8');
    $new_pass = md5($_POST['new_pass']);
    $new_pass = htmlspecialchars($new_pass, ENT_QUOTES, 'UTF-8');
    $confirm_pass = md5($_POST['confirm_pass']);
    $confirm_pass = htmlspecialchars($confirm_pass, ENT_QUOTES, 'UTF-8');

    if(!empty($previous_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        if($previous_pass != $old_pass){
            $message[]='Old password not matched!';
        }elseif($new_pass != $confirm_pass){
            $message[]='Confirm password not matched';
        }else{
            $update_password=$conn->prepare("UPDATE `registration` SET password =? WHERE id = ?");
            $update_password->execute([$confirm_pass, $user_id]);
            $message[]='Password has been updated';
        }
    }
}

$select_profile = $conn->prepare("SELECT * FROM `registration` WHERE id = ?");
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="image/favi.ico" type="image/x-icon">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <!-- Navbar content -->
        </div>
    </nav>

    <section class="container">
        <h2 class="title text-center"><span>Update your profile</span></h2>
        <!-- Display messages -->
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

        <!-- Form for updating profile -->
        <div class="user-update">
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Display user profile information -->

                <!-- Allow admins to update other user profiles -->
                <?php if($is_admin): ?>
                <!-- Admin-specific form fields or options -->
                <?php endif; ?>

                <!-- Common form fields for both users and admins -->
                <img src="uploaded_img/<?= $fetch_profile['image'];?>" alt="" width="300px" height="300px">
                <div class="update-grid">
                    <div class="field">
                        <label>Username:</label>
                        <input type="text" class="input" placeholder="Enter your name" name="name" value="<?= $fetch_profile['name'];?>">
                    </div>
                    <div class="field">
                        <label>Email:</label>
                        <input type="email" class="input" placeholder="Enter your email" name="email" value="<?= $fetch_profile['email'];?>">
                    </div>
                    <div class="field">
                        <input type="hidden" name="old_image" value="<?= $fetch_profile['image'];?>">
                        <label>Profile picture:</label>
                        <input type="file" name="image" class="imagefile" accept="image/jpg, image/png, image/jpeg">
                    </div>
                    <div class="field">
                        <input type="hidden" name="old_pass" value="<?= $fetch_profile['password'];?>">
                        <label>Old password:</label>
                        <input type="password" class="input" placeholder="Enter previous password" name="previous_pass">
                    </div>
                    <div class="field">
                        <label>New password:</label>
                        <input type="password" class="input" placeholder="Enter new password" name="new_pass">
                    </div>
                    <div class="field">
                        <label>Confirm password:</label>
                        <input type="password" class="input" placeholder="Confirm new password" name="confirm_pass">
                    </div>
                </div>
                <input type="submit" name="update" value="Update Profile" class="btn btn-primary">
                <a href="user_main.php" class="btn btn-dark">Go Back</a>
            </form>
        </div>
    </section>

    <footer class="footer bg-black">
        <!-- Footer content -->
    </footer>

    <script src="js/main.js"></script>
</body>
</html>
