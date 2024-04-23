<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadDir = 'uploads/';
    $targetFile = $uploadDir . basename($_FILES["file"]["name"]);

    $auth_id = $_POST['auth_id'];

    if (!file_exists($uploadDir) && !is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        $filename = basename($_FILES["file"]["name"]);
        $filesize = $_FILES["file"]["size"];
        $filetype = $_FILES["file"]["type"];

        $conn = mysqli_connect("localhost", "root", "", "dossier");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO files (filename, filesize, filetype, AUTH_ID) VALUES ('$filename', $filesize, '$filetype', '$auth_id')";
        $conn->query($sql);
        $conn->close();

        header("Location: document.php");
    } else {
        echo "Failed to upload file.";
    }
}
