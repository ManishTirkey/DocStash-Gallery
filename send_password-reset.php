
<?php
include 'config.php';

// Function to update password in the database
function updatePassword($conn, $username, $newPassword) {
    $sql = "UPDATE users SET password = :password WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $username, PDO::PARAM_STR);
    $stmt->bindParam(":password", $newPassword, PDO::PARAM_STR);
    $stmt->execute();
}

// Request to update password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $newPassword = $_POST["new_password"];

    // Hash the new password before updating it in the database
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password in the database
    updatePassword($conn, $username, $hashedPassword);

    echo "Password updated successfully.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="send_password-reset.php" method="post">
        <label for="new_password">New Password:</label><br>
        <input type="password" id="new_password" name="new_password" required><br><br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
