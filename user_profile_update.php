<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
if(!isset($user_id)){
    header('location:login.php');
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
            $message[]='image size is too larger';
        }else{
            $update_image = $conn->prepare("UPDATE `registration` SET image =? WHERE id = ?");
            $update_image->execute([$image ,$user_id]);


            if($update_image){
                move_uploaded_file($image_tmp_name,$image_folder);
                unlink('uploaded_img/'.$old_image);
                $message[] = 'image has been updated';
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
  if(!empty($previous_pass)|| !empty($new_pass)|| !empty($confirm_pass))
 {
  if($previous_pass != $old_pass){
    $message[]='old password not matched!';
  }elseif($new_pass != $confirm_pass){
    $message[]=' confirm password not matched';
  }else{
    $update_password=$conn->prepare("UPDATE `registration` SET password =? WHERE id = ?");
    $update_password->execute([$confirm_pass, $user_id]);
    $message[]='password has been updated';
  }
  }


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
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet"/>
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
                    
                   
                    
                    <li><a href="user_main.php" >Go Back</a></li>
                    
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
                    <li><a href="index.html" class="active">Home</a></li>
                    <li><a href="#people">People</a></li>
                    <li><a href="#about">About us</a></li>
                    <li><a href="#video">How to</a></li>
                    <li><a href="#">Feedback</a></li>
                    <li><a href="login.php"  class="btn"><i class="fas fa-user"></i>Login</a></li>
                </ul>
            </div>
        </div>
    </nav>




      <section class="container" >
      <h2 class=" title text-center"><span> Update your  profile</span></h2>
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
        <div class="user-update" >
       
   <?php
   $select_profile = $conn->prepare("SELECT * FROM `registration`  WHERE id = ?");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    
 ?>



   <form action="" method="post" enctype="multipart/form-data">
   
   <img src="uploaded_img/<?= $fetch_profile['image'];?>" alt="" width="300px" height="300px">
   <div class="update-grid">
        <div class="field">
        <label >UsesrName:</label>
    <input type="text" class="input" placeholder="enter your name" name="name" value="<?= $fetch_profile['name'];?>">
         </div>
                    <div class="field ">
                    <label for="">email:</label>
                        <input type="email" class="input" placeholder=" Enter your email" name="email"  value="<?= $fetch_profile['email'];?>">
                    </div>

                   <div class="field">
                        <input type="hidden" name="old_image" value="<?= $fetch_profile['image'];?>">
                    <label >profile picture:</label>
                        <input type="file" name="image" class="imagefile" accept="image/jpg, image/png, image/jpeg" >
                    </div>

                    <div class="field ">

                    <input type="hidden" name="old_pass"  value="<?= $fetch_profile['password'];?>">

                    <label >old password:</label>
                        <input type="password" class="input" placeholder="enter previous password" name="previous_pass"></div>
                    <div class="field">
                    <label >new password:</label>
                    <input type="password" class="input" placeholder="enter new password" name="new_pass">
                    </div>

                    <div class="field">
                    <label >confirm password:</label>
                    <input type="password" class="input" placeholder=" confirm  new password" name="confirm_pass">
                    </div>
                    </div>
                    <input type="submit" name="update" value="Update Profile" class=" btn btn-primary">
                    <a href="user_main.php" class="btn btn-dark">Go Back</a>
  
   </div>
   </div>
   
   </form>

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