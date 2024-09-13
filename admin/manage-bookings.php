<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../conFile/conection.php';

// Check if user is logged in
if (!isset($_SESSION['alogin']) || strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
}

// Handle cancel action
if (isset($_REQUEST['bkid'])) {
    $bid = intval($_GET['bkid']);
    $status = 2;
    $cancelby = 'a';
    $sql = "UPDATE tblbooking SET status=?, CancelledBy=? WHERE BookingId=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param('isi', $status, $cancelby, $bid);
    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }
    $msg = "Booking Cancelled successfully";
}

// Handle confirm action
if (isset($_REQUEST['bckid'])) {
    $bcid = intval($_GET['bckid']);
    $status = 1;
    $sql = "UPDATE tblbooking SET status=? WHERE BookingId=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param('ii', $status, $bcid);
    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }
    $msg = "Booking Confirmed successfully";
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>LVA | Admin Manage Bookings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="css/morris.css" type="text/css" />
    <link href="css/font-awesome.css" rel="stylesheet">
    <script src="js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/table-style.css" />
    <link rel="stylesheet" type="text/css" href="css/basictable.css" />
    <script type="text/javascript" src="js/jquery.basictable.min.js"></script>
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

    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebarmenu.php'); ?>
    <div class="clearfix"></div>
    <div class="page-container">
        <!--/content-inner-->
        <div class="left-content">
            <div class="mother-grid-inner">
                <!--header start here-->
                <div class="clearfix"></div>
            </div>
            <!--header end here-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Manage
                    Bookings</li>
            </ol>
            <div class="agile-grids">
                <!-- tables -->
                <?php if (isset($error)) { ?>
                    <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlspecialchars($error); ?> </div>
                <?php } elseif (isset($msg)) { ?>
                    <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlspecialchars($msg); ?> </div>
                <?php } ?>
                <div class="agile-tables">
                    <div class="w3l-table-info">
                        <h2>Manage Bookings</h2>
                        <table id="table">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Name</th>
                                    <th>Email ID</th>
                                    <th>Package Name</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT 
                                        tblbooking.BookingId AS bookid, 
                                        user_reg.user_name AS user_name, 
                                        user_reg.user_email AS user_email,  
                                        tbltourpackages.PackageName AS pckname, 
                                        tblbooking.Comment AS comment, 
                                        tblbooking.status AS status, 
                                        tblbooking.CancelledBy AS cancelby, 
                                        tblbooking.UpdationDate AS upddate 
                                    FROM 
                                        tblbooking
                                    LEFT JOIN 
                                        user_reg 
                                    ON 
                                        tblbooking.user_email = user_reg.user_email
                                    LEFT JOIN 
                                        tbltourpackages 
                                    ON 
                                        tbltourpackages.PackageId = tblbooking.PackageId";
                                $stmt = $conn->prepare($sql);
                                if (!$stmt) {
                                    die('Prepare failed: ' . $conn->error);
                                }
                                if (!$stmt->execute()) {
                                    die('Execute failed: ' . $stmt->error);
                                }
                                $results = $stmt->get_result();
                                if ($results->num_rows > 0) {
                                    while ($result = $results->fetch_object()) { ?>
                                        <tr>
                                            <td>#BK-<?php echo htmlspecialchars($result->bookid); ?></td>
                                            <td><?php echo htmlspecialchars($result->user_name); ?></td>
                                            <td><?php echo htmlspecialchars($result->user_email); ?></td>
                                            <td><?php echo htmlspecialchars($result->pckname); ?></td>
                                            <td><?php echo htmlspecialchars($result->comment); ?></td>
                                            <td>
                                                <?php if ($result->status == 0) {
                                                    echo "Pending";
                                                } elseif ($result->status == 1) {
                                                    echo "Confirmed";
                                                } elseif ($result->status == 2 && $result->cancelby == 'a') {
                                                    echo "Cancelled by you at " . htmlspecialchars($result->upddate);
                                                } elseif ($result->status == 2 && $result->cancelby == 'u') {
                                                    echo "Cancelled by User at " . htmlspecialchars($result->upddate);
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($result->status == 2) { ?>
                                                    Cancelled
                                                <?php } elseif ($result->status == 1) { ?>
                                                    Confirmed
                                                <?php } else { ?>
                                                    <a href="manage-bookings.php?bkid=<?php echo htmlspecialchars($result->bookid); ?>"
                                                        onclick="return confirm('Do you really want to cancel booking')">Cancel</a>
                                                    /
                                                    <a href="manage-bookings.php?bckid=<?php echo htmlspecialchars($result->bookid); ?>"
                                                        onclick="return confirm('Booking has been confirmed')">Confirm</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No bookings found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                <div class="copy">
                    <p>&copy; 2024 Learning Voyage and Adventure. All Rights Reserved | Design by <a
                            href="http://w3layouts.com/" target="_blank">W3layouts</a></p>
                </div>
                <!--copy rights end here-->
            </div>
        </div>
        <!--/content-inner-->
        <!--/sidebar-menu-->
    </div>
</body>

</html>