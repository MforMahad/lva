<?php
session_start();
require '../conFile/conection.php';

// Check if the user is logged in
if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
	exit();
}

// Check if the user_role is set in session
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

?>
<!DOCTYPE HTML>
<html>

<head>
	<title>LVA | Admin Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/morris.css" type="text/css" />
	<!-- Graph CSS -->
	<link href="css/font-awesome.css" rel="stylesheet">
	<!-- jQuery -->
	<script src="js/jquery-2.1.4.min.js"></script>
	<!-- //jQuery -->
	<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet'
		type='text/css' />
	<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<!-- lined-icons -->
	<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
	<!-- //lined-icons -->
	<style>
		.footer {
			position: fixed;
			bottom: 0;
			width: 100%;
			background-color: #f1f1f1;
			text-align: center;
			padding: 10px;
		}
	</style>
</head>

<body>
	<div class="page-container">
		<div class="left-content">
			<div class="mother-grid-inner">
				<!--header start here-->
				<?php include('includes/header.php'); ?>
				<!--header end here-->
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="dashboard.php">Home</a> <i class="fa fa-angle-right"></i></li>
				</ol>
				<div class="four-grids">
					<?php if ($user_role == 1) { ?>
						<a href="manage-users.php" target="_blank">
							<div class="col-md-4 four-grid">
								<div class="four-agileits">
									<div class="icon">
										<i class="glyphicon glyphicon-user" aria-hidden="true"></i>
									</div>
									<div class="four-text">
										<h3>User</h3>
										<?php
										$sql = "SELECT user_id FROM user_reg";
										$result = $conn->query($sql);
										$cnt = $result ? $result->num_rows : 0;
										?>
										<h4><?php echo htmlentities($cnt); ?></h4>
									</div>
								</div>
							</div>
						</a>
					<?php } ?>

					<?php if ($user_role == 1 || $user_role == 2) { ?>
						<a href="manage-packages.php" target="_blank">
							<div class="col-md-4 four-grid">
								<div class="four-wthree">
									<div class="icon">
										<i class="glyphicon glyphicon-briefcase" aria-hidden="true"></i>
									</div>
									<div class="four-text">
										<h3>Total packages</h3>
										<?php
										$sql = "SELECT PackageId FROM tbltourpackages";
										$result = $conn->query($sql);
										$cnt1 = $result ? $result->num_rows : 0;
										?>
										<h4><?php echo htmlentities($cnt1); ?></h4>
									</div>
								</div>
							</div>
						</a>
					<?php } ?>

					<?php if ($user_role == 1) { // Only for admin ?>
						<a href="manageissues.php" target="_blank">
							<div class="col-md-4 four-grid">
								<div class="four-w3ls">
									<div class="icon">
										<i class="glyphicon glyphicon-folder-open" aria-hidden="true"></i>
									</div>
									<div class="four-text">
										<h3>Issues Raised</h3>
										<?php
										$sql3 = "SELECT id FROM tblissues";
										$result = $conn->query($sql3);
										$cnt2 = $result ? $result->num_rows : 0;
										?>
										<h4><?php echo htmlentities($cnt2); ?></h4>
									</div>
								</div>
							</div>
						</a>
					<?php } ?>

					<div class="clearfix"></div>
				</div>

				<div class="four-grids">
					<?php if ($user_role == 1 || $user_role == 2) { ?>
						<a href="manage-bookings.php" target="_blank">
							<div class="col-md-3 four-grid">
								<div class="four-agileinfo">
									<div class="icon">
										<i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>
									</div>
									<div class="four-text">
										<h3>Bookings</h3>
										<?php
										$sql = "SELECT BookingId FROM tblbooking";
										$result = $conn->query($sql);
										$cnt4 = $result ? $result->num_rows : 0;
										?>
										<h4><?php echo htmlentities($cnt4); ?></h4>
									</div>
								</div>
							</div>
						</a>
					<?php } ?>

					<?php if ($user_role == 1 || $user_role == 2) { ?>
						<a href="manage-bookings.php" target="_blank">
							<div class="col-md-3 four-grid">
								<div class="four-wthree" style="color:#ffc107 !important">
									<div class="icon">
										<i class="glyphicon glyphicon-list-alt" aria-hidden="true"></i>
									</div>
									<div class="four-text">
										<h3>New Bookings</h3>
										<?php
										$sql = "SELECT BookingId FROM tblbooking WHERE status IS NULL OR status = ''";
										$result = $conn->query($sql);
										$newbookings = $result ? $result->num_rows : 0;
										?>
										<h4><?php echo htmlentities($newbookings); ?></h4>
									</div>
								</div>
							</div>
						</a>
					<?php } ?>

					<?php if ($user_role == 1) { // Only for admin ?>
						<a href="manage-bookings.php" target="_blank">
							<div class="col-md-3 four-grid">
								<div class="four-agileits" style="color:#76ff03 !important">
									<div class="icon">
										<i class="glyphicon glyphicon-ok-circle" aria-hidden="true"></i>
									</div>
									<div class="four-text">
										<h3>Confirm Bookings</h3>
										<?php
										$sql = "SELECT BookingId FROM tblbooking WHERE status = '1'";
										$result = $conn->query($sql);
										$confirmbooking = $result ? $result->num_rows : 0;
										?>
										<h4><?php echo htmlentities($confirmbooking); ?></h4>
									</div>
								</div>
							</div>
						</a>
					<?php } ?>

					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<?php include('includes/sidebarmenu.php'); ?>
		<?php include('includes/footer.php'); ?>
	</div>
	<script>
		var toggle = true;

		$(".sidebar-icon").click(function () {
			if (toggle) {
				$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
				$("#menu span").css({ "position": "absolute" });
			} else {
				$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
				setTimeout(function () {
					$("#menu span").css({ "position": "relative" });
				}, 400);
			}

			toggle = !toggle;
		});
	</script>
	<!--js -->
	<script src="js/scripts.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>
</body>

</html>