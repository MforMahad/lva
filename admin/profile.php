<?php
session_start();
//error_reporting(0);
include '../conFile/conection.php'; // Update this file to use mysqli if not already

if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {

	if (isset($_POST['submit'])) {
		$adminid = $_SESSION['alogin'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];

		// Update query using mysqli
		$sql = "UPDATE admin_log SET Name=?, Email=?, MobileNumber=? WHERE UserName=?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('ssss', $name, $email, $mobile, $adminid);

		if ($stmt->execute()) {
			echo "<script>alert('Profile has been updated.');</script>";
			echo "<script>window.location.href='profile.php';</script>";
		} else {
			echo "<script>alert('Error updating profile.');</script>";
		}

		$stmt->close();
	}
	?>

	<!DOCTYPE HTML>
	<html>

	<head>
		<title>LVA | Admin Profile</title>

		<script type="application/x-javascript">
									addEventListener("load", function () {
										setTimeout(hideURLbar, 0);
									}, false);

									function hideURLbar() {
										window.scrollTo(0, 1);
									}
								</script>

		<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
		<link href="css/style.css" rel='stylesheet' type='text/css' />
		<link rel="stylesheet" href="css/morris.css" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet">
		<script src="js/jquery-2.1.4.min.js"></script>
		<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet'
			type='text/css' />
		<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />

		<style>
			.errorWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #dd3d36;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}

			.succWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #fff;
				border-left: 4px solid #5cb85c;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}
		</style>

	</head>

	<body>
		<div class="page-container">
			<!--/content-inner-->
			<div class="left-content">
				<div class="mother-grid-inner">
					<!--header start here-->
					<?php include('includes/header.php'); ?>

					<div class="clearfix"></div>
				</div>
				<!--heder end here-->
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Admin
						Profile</li>
				</ol>
				<!--grid-->
				<div class="grid-form">

					<div class="grid-form1">

						<div class="panel-body">
							<form name="chngpwd" method="post" class="form-horizontal" onSubmit="return valid();">
								<?php
								$adminid = $_SESSION['alogin'];
								$sql = "SELECT * FROM admin_log WHERE UserName=?";
								$stmt = $conn->prepare($sql);
								$stmt->bind_param('s', $adminid);
								$stmt->execute();
								$result = $stmt->get_result();

								if ($result->num_rows > 0) {
									while ($row = $result->fetch_assoc()) { ?>

										<div class="form-group">
											<label class="col-md-2 control-label">User Name</label>
											<div class="col-md-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-key"></i>
													</span>
													<input class="form-control1" type="text" name="name" id="name"
														value="<?php echo htmlspecialchars($row['UserName']); ?>">
												</div>
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label">Name</label>
											<div class="col-md-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-key"></i>
													</span>
													<input class="form-control1" type="text" name="name" id="name"
														value="<?php echo htmlspecialchars($row['Name']); ?>">
												</div>
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label">Email</label>
											<div class="col-md-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-key"></i>
													</span>
													<input class="form-control1" type="text" name="email" id="email"
														value="<?php echo htmlspecialchars($row['Email']); ?>">
												</div>
											</div>
										</div>

										<div class="form-group">
											<label class="col-md-2 control-label">Mobile No</label>
											<div class="col-md-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-key"></i>
													</span>
													<input class="form-control1" type="text" name="mobile" id="mobile"
														value="<?php echo htmlspecialchars($row['MobileNumber']); ?>">
												</div>
											</div>
										</div>

									<?php }
								}
								$stmt->close();
								?>
								<div class="col-sm-8 col-sm-offset-2">
									<button type="submit" name="submit" class="btn-primary btn">Submit</button>
									<button type="reset" class="btn-inverse btn">Reset</button>
								</div>
						</div>

						</form>
					</div>
				</div>
			</div>
		</div>
		<!--//grid-->

		<!-- script-for sticky-nav -->
		<script>
			$(document).ready(function () {
				var navoffeset = $(".header-main").offset().top;
				$(window).scroll(function () {
					var scrollpos = $(window).scrollTop();
					if (scrollpos >= navoffeset) {
						$(".header-main").addClass("fixed");
					} else {
						$(".header-main").removeClass("fixed");
					}
				});

			});
		</script>
		<!-- /script-for sticky-nav -->
		<!--inner block start here-->
		<div class="inner-block">

		</div>
		<!--inner block end here-->
		<!--copy rights start here-->
		<?php include('includes/footer.php'); ?>
		<!--COPY rights end here-->
		</div>
		</div>
		<!--//content-inner-->
		<!--/sidebar-menu-->
		<?php include('includes/sidebarmenu.php'); ?>
		<div class="clearfix"></div>
		</div>
		<script>
			var toggle = true;

			$(".sidebar-icon").click(function () {
				if (toggle) {
					$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
					$("#menu span").css({ "position": "absolute" });
				}
				else {
					$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
					setTimeout(function () {
						$("#menu span").css({ "position": "relative" });
					}, 400);
				}

				toggle = !toggle;
			});
		</script>
		<script src="js/jquery.nicescroll.js"></script>
		<script src="js/scripts.js"></script>
		<script src="js/bootstrap.min.js"></script>

	</body>

	</html>
<?php } ?>