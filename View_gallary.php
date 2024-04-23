<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<link rel="stylesheet" href="css/gallery.css">
</head>

<body>

	<h2>Your Gallery</h2>
	<div class="container">
		<h3>

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

			$result = $conn->query("SELECT * FROM files WHERE AUTH_ID = $user_id");

			if ($result->num_rows > 0) {
				echo "$result->num_rows" . " Files Found.";
				echo "</h3>";
				echo "<div class='img_container'>";

				while ($row = $result->fetch_assoc()) {
					// echo "<li>{$row['filename']} ({$row['filesize']} bytes) -<button> <a href='download.php?id={$row['id']}'>Download</a></button> | <button><a href='view.php?id={$row['id']}'>View</a> </button>| <button><a href='delete.php?id={$row['id']}'>Delete</a></button></li>";
					$filename = 'uploads/' . $row['filename'];
					$filetype = $row['filetype'];

					$dir = dirname($filename);
					$file = pathinfo($filename, PATHINFO_FILENAME);
					$extension = pathinfo($filename, PATHINFO_EXTENSION);
					$Filename = $file . "." . $extension;

					if (strpos($filetype, 'pdf') !== false) {
						// $pdf = new Imagick();

						// If the file is a PDF, display using an <iframe>
						echo "<div class='img'>";
						echo "<img src='image/pdf_img.png' alt='pdf'>";
						// echo "<iframe src='$filename'></iframe>";

					} elseif (strpos($filetype, 'image') !== false) {
						// If the file is an image, display using <img>
						echo "<div class='img'>";
						echo "<img src='$filename' alt='img'>";
					}
					echo "<div class='controller-wrapper'>";
					echo "<h4>$Filename</h4>";
					echo "<div class='controllers'>
					<a href='download.php?id={$row['id']}' >Download</a>
					<a href='view.php?id={$row['id']}' target='_blank'>View</a>
					<a href='delete.php?id={$row['id']}'>Delete</a>
					</div>";



					echo "</div>";
					echo "</div>";
				}
				echo "</div>";
			}
			$conn->close();
			?>

	</div>

	<script>

	</script>
</body>

</html>