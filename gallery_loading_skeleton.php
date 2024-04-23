<?php

session_start();
include 'config.php';

$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
	header('location:login.php');
}

if (isset($_POST['submit'])) {

	$in_pin = $_POST['pin'];
	$in_pin = htmlspecialchars($in_pin, ENT_QUOTES, 'UTF-8');

	$conn = mysqli_connect("localhost", "root", "", "dossier");

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$user_id = $conn->real_escape_string($user_id); // Escape user input to prevent SQL injection

	// Prepare and execute the query using a prepared statement
	$select = $conn->prepare("SELECT pin FROM personal_detail WHERE id = ?");
	$select->bind_param("i", $user_id); // "i" indicates integer type
	$select->execute();
	$select->store_result(); // Store the result for accessing num_rows

	// Check if the query was successful and rows were returned
	if ($select && $select->num_rows > 0) {
		// Fetch the row as an associative array
		$select->bind_result($pin); // Bind the result to $pin variable
		$select->fetch();

		// Check if the provided pin matches the fetched pin
		if ($pin == $in_pin) {
			header('Location: View_gallary.php');
			exit(); // Always use exit() after header('Location: ...') to stop further execution
		} else {
			header('Location: gallery_loading_skeleton.php');
			exit();
		}
	} else {
		// No rows found or query failed
		header('Location: gallery_loading_skeleton.php');
		exit();
	}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="css/skeleton_loading.css">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>

	<div class="my-container">

		<?php

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
			$i = 0;

			while ($i <= 10) {
				echo '<div class="loading-container">
        <div class="loading__image loading"></div>
        <div class="loading__title loading"></div>
        <div class="loading__description loading"></div>
    </div>';
				$i++;
			}
		}
		$conn->close();
		?>
	</div>

	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pinModal" id="modal-btn">
		Launch demo modal
	</button>

	<div class="modal PinModal fade" tabindex="-1" id="pinModal" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Enter Secret Pin </h5>
				</div>
				<form action="gallery_loading_skeleton.php" method="Post">
					<div class="modal-body">
						<label for="pin">Pin: </label>
						<input type="text" name="pin" id="pin" autocomplete="off">
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" name="submit" value="Submit">
					</div>
				</form>
			</div>
		</div>
	</div>



	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

	<script>
		var myModal = new bootstrap.Modal(document.getElementById('pinModal'), {
			keyboard: false
		})

		myModal.show();
	</script>

</body>

</html>