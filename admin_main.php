<?php
include 'config.php';
session_start();

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Fetch admin details from the database
if(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
    $select_admin_query = $conn->prepare("SELECT * FROM `registration` WHERE id = ?");
    $select_admin_query->execute([$admin_id]);
    $admin_details = $select_admin_query->fetch(PDO::FETCH_ASSOC);
}

// Deactivate or activate account based on button click
if(isset($_POST['deactivate'])){
    $id = $_POST['deactivate'];
    $status = $_POST['status'] == 'active' ? 'inactive' : 'active';
    
    $update_query = $conn->prepare("UPDATE `registration` SET status=? WHERE id=?");
    $update_query->execute([$status, $id]);
}

// Delete account based on button click
if(isset($_POST['delete'])){
    $id = $_POST['delete'];
    
    $delete_query = $conn->prepare("DELETE FROM `registration` WHERE id=?");
    $delete_query->execute([$id]);
}

// Query to fetch account names
$select_query = $conn->query("SELECT id, name, status FROM `registration`");
$accounts = $select_query->fetchAll(PDO::FETCH_ASSOC);

// Query to count the number of registered users
$count_query = $conn->query("SELECT COUNT(*) AS total_registered FROM `registration`");
$count_result = $count_query->fetch(PDO::FETCH_ASSOC);
$total_registered = $count_result['total_registered'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
    
</head>
<body>
<nav class="navbar">
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="image/logo.jpg" alt="logo"> </a>
            </div>
            <div class="main-menu">
                <ul>
                    <li><a href="admin_profile_update.php">Edit</a></li>
                    <li><a class="btn " href="logout.php">Logout</a></li>
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
                   <li><a href="admin_profile_update.php">Edit</a></li>
                    <li><a class="btn " href="logout.php">Logout</a></li>
                    
                </ul>
            </div>
        </div>
    </nav>




    <div class="container">

    <div class="account-list">
      <h1 class="title text-center"><span>WELCOME ADMIN</span></h1><br>
    
    <h2>Admin Details</h2>
        <?php if(isset($admin_details) && !empty($admin_details)): ?>
            <p class="text-md">Admin ID: <?php echo $admin_details['id']; ?></p>
            <p class="text-md">Admin Name: <?php echo sanitize($admin_details['name']); ?></p>
            <!-- Add more details as needed -->
        <?php endif; ?>
<hr>

        <h2>Total registrations: <?php echo $total_registered; ?></h2>
        <hr>
        <h2>Account List</h2>
        <?php 
        if (isset($accounts) && !empty($accounts)) {
            echo '<ul>';
            foreach ($accounts as $account) {
                $status = $account['status'] == 'active' ? 'inactive' : 'active';
                $status_class = $account['status'] == 'active' ? 'active' : 'inactive';
                echo '<li>' . sanitize($account['name']) . '
                        <form method="post" action="">
                            <input type="hidden" name="deactivate" value="' . $account['id'] . '">
                            <input type="hidden" name="status" value="' . $account['status'] . '">
                            <button class="' . $status_class . '" type="submit">' . ucfirst($status) . '</button>
                        </form>
                        <form method="post" action="">
                            <input type="hidden" name="delete" value="' . $account['id'] . '">
                            <button  class="btn-dark" type="submit">Delete</button>
                        </form>
                    </li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No accounts found.</p>';
        }
        ?>

       
</div>
    </div>
</body>
</html>
