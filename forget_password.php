<?php
include 'config.php';
$change_status = 0;
$email = '';
if (isset($_POST['submit'])) {

	$email = $_POST['email'];
	$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

	$npass = $_POST['npassword'];
	$npass = htmlspecialchars($npass, ENT_QUOTES, 'UTF-8');

	$select = $conn->prepare("SELECT * FROM `registration` WHERE email=?");
	$select->execute([$email]);


	// Fetch the result
	$result = $select->fetch(PDO::FETCH_ASSOC);

	// Check if a result was found
	if ($result) {
		// $password = $result['password'];
		$id = $result['id'];
		$newPasswordHash = md5($npass);

		$update = $conn->prepare("UPDATE registration SET password = ? WHERE id = ?");
		$update->execute([$newPasswordHash, $id]);

		$change_status = 1;
	} else {
		$change_status = -1;
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Growth app | Forget Password</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


	<!-- font awesome -->
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /> -->

	<!-- font -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
	<!-- symol -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- css -->
	<link rel="stylesheet" href="css/forget_password.css">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


</head>

<body>
	<div class="wrapper">
		<form id="forgetPasswordForm" method="post" action="forget_password.php">
			<h2 class="heading" id="heading">Recover Your Password</h2>

			<h3 class="inst" id="inst">Enter Your email</h3>
			<div class="email-fill">

				<input type="email" name="email" id="email" title="enter valid Email" placeholder="Enter your email" required <?php if ($change_status == -1) {
																																	echo 'class="error"';
																																	echo 'value=' . $email;
																																} ?> />
				<input type="password" name="npassword" id="password" placeholder="Enter New password" required />
				<?php if ($change_status == -1) echo "<p class='error-message'>Error on Email</p>" . "<p>Make sure It is Correct.</p>"; ?>
				<?php if ($change_status == 1) echo "<p class='success-message'>Password Changed Successfully</p>" ?>

			</div>
			<div class="verify-btn">
				<input type="submit" name="submit" value="verify" />
			</div>
		</form>
	</div>

	<!-- bootstrap script -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>