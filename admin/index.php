<?php
session_start();
require '../conFile/conection.php';

if (isset($_POST['login'])) {
	$uname = $_POST['username'];
	$password = md5($_POST['password']);



	// Prepare SQL statement
	$sql = "SELECT UserName, Password, role FROM admin_log WHERE UserName=? AND Password=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("ss", $uname, $password);

	// Execute the statement
	$stmt->execute();
	$result = $stmt->get_result()->fetch_assoc();

	if ($result) {
		// Store username and role in session variables
		$_SESSION['alogin'] = $result['UserName'];
		$_SESSION['role'] = $result['role'];

		// Redirect to the dashboard
		echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
	} else {
		echo "<script>alert('Invalid Details');</script>";
	}

	// Close statement and connection
	$stmt->close();
	$conn->close();
}
?>



<!DOCTYPE HTML>
<html>

<head>
	<title>LVA | Admin Sign in</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script
		type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/morris.css" type="text/css" />
	<!-- Graph CSS -->
	<link href="css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<!-- jQuery -->
	<script src="js/jquery-2.1.4.min.js"></script>
	<!-- //jQuery -->
	<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet'
		type='text/css' />
	<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<!-- lined-icons -->
	<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
	<!-- //lined-icons -->
</head>

<body>
	<div class="main-wthree">
		<div class="container">
			<div class="sin-w3-agile">
				<h2>Sign In</h2>
				<form method="post">
					<div class="username">
						<span class="username">Username:</span>
						<input type="text" name="username" class="name" placeholder="" required="">
						<div class="clearfix"></div>
					</div>
					<div>
						<a href="forgot-password.php" style="color: #fff;">Forgot Password</a>
					</div>
					<br>
					<div class="password-agileits">
						<span class="username">Password:</span>
						<input type="password" name="password" class="password" placeholder="" required="">
						<div class="clearfix"></div>
					</div>

					<div class="login-w3">
						<input type="submit" class="login" name="login" value="Sign In">
					</div>
					<div class="clearfix"></div>
				</form>
				<div class="back">
					<a href="../index.php" style="color: #fff;">Back to home</a>
				</div>

			</div>
		</div>
	</div>
</body>

</html>