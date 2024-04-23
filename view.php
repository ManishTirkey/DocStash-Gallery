<?php
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
    $filetype = $row['filetype'];

    if (strpos($filetype, 'pdf') !== false) {
        // If the file is a PDF, display using an <iframe>
        echo "<iframe src='$filename' width='100%' height='500px' style='border: none;'></iframe>";
    } elseif (strpos($filetype, 'image') !== false) {
        // If the file is an image, display using <img>
        echo "<img src='$filename' alt='Document'>";
    } else {
        // If the file type is not supported, display a message
        echo "File type not supported for viewing.";
    }
} else {
    echo "File not found.";
}
$conn->close();
?>
