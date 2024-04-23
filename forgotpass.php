<?php
include 'config.php';

// Function to retrieve email associated with the provided username from the database
function getUserDetails($conn, $username) {
    $sql = "SELECT email FROM registration WHERE name = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row; // Return the fetched email
}

// Function to update password in the database
function updatePassword($conn, $username, $newPassword) {
    $sql = "UPDATE registration SET password = :password WHERE name = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->bindParam(":password", $newPassword, PDO::PARAM_STR);
    $stmt->execute();
}

// Request for password reset
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];

    // Fetch email associated with the provided username from the database
    $userDetails = getUserDetails($conn, $username);

    if ($userDetails && $userDetails["email"] == $email) {
        // Email and username match, redirect to reset password page
        header("Location: send_password-reset.php?username=" . urlencode($username));
        exit;
    } else {
        // Email and username do not match
        echo "Invalid username or email.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="post">
        <label for="username">Name:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
