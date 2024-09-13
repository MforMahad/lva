<div class="sidebar-menu">
	<!-- Sidebar content here -->
	<header class="logo1">
		<a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a>
	</header>
	<div style="border-top:1px ridge rgba(255, 255, 255, 0.15)"></div>
	<div class="menu">
		<ul id="menu">
			<?php
			// Start session
			
			// Check if the user is logged in and get their role
			$userRole = null;
			if (isset($_SESSION['alogin'])) {
				$userRole = $_SESSION['role']; // Assuming 'role' is stored in the session
			}

			// Display menu items based on user role
			if ($userRole == 1) { // Role 1 can see all items ?>
				<li><a href="dashboard.php"><i class="fa fa-tachometer"></i> <span>Dashboard</span>
						<div class="clearfix"></div>
					</a></li>

				<li id="menu-academico"><a href="manage-users.php"><i class="fa fa-users"
							aria-hidden="true"></i><span>Manage Users</span>
						<div class="clearfix"></div>
					</a></li>

				<li id="menu-academico"><a href="#"><i class="fa fa-list-ul" aria-hidden="true"></i><span>Tour
							Packages</span> <span class="fa fa-angle-right" style="float: right"></span>
						<div class="clearfix"></div>
					</a>
					<ul id="menu-academico-sub">
						<li id="menu-academico-avaliacoes"><a href="create-package.php">Create</a></li>
						<li id="menu-academico-avaliacoes"><a href="manage-packages.php">Manage</a></li>
					</ul>
				</li>

				<li><a href="manage-bookings.php"><i class="fa fa-list" aria-hidden="true"></i> <span>Manage Booking</span>
						<div class="clearfix"></div>
					</a></li>

				<li id="menu-academico"><a href="#"><i class="fa fa-arrows-alt" aria-hidden="true"></i>
						<span>Live Stream Package</span> <span class="fa fa-angle-right" style="float: right"></span>
						<div class="clearfix"></div>
					</a>
					<ul id="menu-academico-sub">
						<li id="menu-academico-avaliacoes"><a href="create-live-package.php">Create</a></li>
						<li id="menu-academico-avaliacoes"><a href="manage-live-packages.php">Manage</a></li>
					</ul>
				</li>

				<li><a href="manage-live-bookings.php"><i class="fa fa-book" aria-hidden="true"></i><span>Manage Live
							Booking</span>
						<div class="clearfix"></div>
					</a></li>

				<li><a href="go-live.php"><i class="fa fa-video-camera" aria-hidden="true"></i> <span>Live Stream</span>
						<div class="clearfix"></div>
					</a></li>

				<li><a href="manage-payments.php"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> <span>Manage
							Payments</span>
						<div class="clearfix"></div>
					</a></li>

				<li><a href="manageissues.php"><i class="fa fa-question-circle" aria-hidden="true"></i> <span>Manage
							Issues</span>
						<div class="clearfix"></div>
					</a></li>

			<?php } elseif ($userRole == 2) { // Role 2 specific menu items ?>
				<li><a href="dashboard.php"><i class="fa fa-tachometer"></i> <span>Dashboard</span>
						<div class="clearfix"></div>
					</a></li>

				<li id="menu-academico"><a href="#"><i class="fa fa-list-ul" aria-hidden="true"></i><span>Tour
							Packages</span> <span class="fa fa-angle-right" style="float: right"></span>
						<div class="clearfix"></div>
					</a>
					<ul id="menu-academico-sub">
						<li id="menu-academico-avaliacoes"><a href="create-package.php">Create</a></li>
						<li id="menu-academico-avaliacoes"><a href="manage-packages.php">Manage</a></li>
					</ul>
				</li>

				<li><a href="manage-bookings.php"><i class="fa fa-list" aria-hidden="true"></i> <span>Manage Booking</span>
						<div class="clearfix"></div>
					</a></li>

				<li><a href="manage-payments.php"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> <span>Manage
							Payments</span>
						<div class="clearfix"></div>
					</a></li>

				<li><a href="manageissues.php"><i class="fa fa-question-circle" aria-hidden="true"></i> <span>Manage
							Issues</span>
						<div class="clearfix"></div>
					</a></li>

			<?php } elseif ($userRole == 3) { // Role 3 specific menu items ?>
				<li><a href="dashboard.php"><i class="fa fa-tachometer"></i> <span>Dashboard</span>
						<div class="clearfix"></div>
					</a></li>

				<li id="menu-academico"><a href="#"><i class="fa fa-arrows-alt" aria-hidden="true"></i>
						<span>Live Stream Package</span> <span class="fa fa-angle-right" style="float: right"></span>
						<div class="clearfix"></div>
					</a>
					<ul id="menu-academico-sub">
						<li id="menu-academico-avaliacoes"><a href="create-live-package.php">Create</a></li>
						<li id="menu-academico-avaliacoes"><a href="manage-live-packages.php">Manage</a></li>
					</ul>
				</li>

				<li><a href="manage-live-bookings.php"><i class="fa fa-book" aria-hidden="true"></i><span>Manage Live
							Booking</span>
						<div class="clearfix"></div>
					</a></li>

				<li><a href="manage-payments.php"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> <span>Manage
							Payments</span>
						<div class="clearfix"></div>
					</a></li>

			<?php } else { ?>
				<!-- Optionally, display a message or redirect if the user has no role or is not logged in -->
				<li><a href="login.php"><i class="fa fa-sign-in"></i> <span>Login</span></a></li>
			<?php } ?>
		</ul>
	</div>
</div>