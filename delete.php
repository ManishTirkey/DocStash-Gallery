<?php

session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
}

$conn = mysqli_connect("localhost", "root", "", "dossier");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM files WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $filename = 'uploads/' . $row['filename'];
    unlink($filename);

    $sql = "DELETE FROM files WHERE id=$id";
    $conn->query($sql);
    $conn->close();

    header("Location: view_gallary.php");
} else {
    echo "File not found.";
}
