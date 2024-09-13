<?php
session_start();
error_reporting(E_ALL); // Show all errors
ini_set('display_errors', 1); // Display errors on the page

require '../conFile/conection.php';

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
}

// Code for cancel
if (isset($_GET['bkid'])) {
    $bid = intval($_GET['bkid']);
    $status = 2;
    $cancelby = 'a'; // Assuming 'a' for admin, change if needed
    $sql = "UPDATE livebookingtable SET status=?, CancelledBy=? WHERE LiveBookingId=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('isi', $status, $cancelby, $bid);
    if ($stmt->execute()) {
        $msg = "Booking Cancelled successfully";
    } else {
        $error = "Error: " . $stmt->error;
    }
}

// Code for confirm
if (isset($_GET['bckid'])) {
    $bcid = intval($_GET['bckid']);
    $status = 1;
    $liveLink = "http://localhost:8080/lva/userPanel/user-view.php?roomID=" . $bcid . "&role=Audience";

    $sql = "UPDATE livebookingtable SET status=?, LiveLink=? WHERE LiveBookingId=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }
    $stmt->bind_param('isi', $status, $liveLink, $bcid);
    if ($stmt->execute()) {
        $msg = "Booking Confirmed successfully.";
    } else {
        $error = "Error: " . $stmt->error;
    }
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
    <div class="mother-grid-inner">
        <!--header start here-->
        <?php include('includes/header.php'); ?>
        <div class="clearfix"> </div>
    </div>
    <div class="page-container">
        <div class="left-content">
            <?php include('includes/sidebarmenu.php'); ?>
            <div class="clearfix"></div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Manage
                    Bookings</li>
            </ol>
            <div class="agile-grids">
                <?php if (isset($error)) { ?>
                    <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlspecialchars($error); ?> </div>
                <?php } else if (isset($msg)) { ?>
                        <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlspecialchars($msg); ?> </div>
                <?php } ?>
                <div class="agile-tables">
                    <div class="w3l-table-info">
                        <h2>Manage Live Stream Bookings</h2>
                        <table id="table">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Name</th>
                                    <th>Email ID</th>
                                    <th>Package Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT 
                                            livebookingtable.LiveBookingId AS bookid, 
                                            user_reg.user_name AS user_name, 
                                            user_reg.user_email AS user_email,  
                                            livestreampackages.PackageName AS pckname,   
                                            livebookingtable.status AS status, 
                                            livebookingtable.CancelledBy AS cancelby, 
                                            livebookingtable.UpdationDate AS upddate
                                        FROM 
                                            livebookingtable
                                        LEFT JOIN 
                                            user_reg 
                                        ON 
                                            livebookingtable.user_email = user_reg.user_email
                                        LEFT JOIN 
                                            livestreampackages 
                                        ON 
                                            livestreampackages.LivePackageId = livebookingtable.LivePackageId";

                                $stmt = $conn->prepare($sql);
                                if (!$stmt) {
                                    die("Prepare failed: " . $conn->error);
                                }
                                $stmt->execute();
                                $results = $stmt->get_result();
                                if ($results->num_rows > 0) {
                                    while ($result = $results->fetch_object()) { ?>
                                        <tr>
                                            <td>#LBK-<?php echo htmlspecialchars($result->bookid); ?></td>
                                            <td><?php echo htmlspecialchars($result->user_name); ?></td>
                                            <td><?php echo htmlspecialchars($result->user_email); ?></td>
                                            <td><?php echo htmlspecialchars($result->pckname); ?></td>
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
                                                    <a href="manage-live-bookings.php?bkid=<?php echo htmlspecialchars($result->bookid); ?>"
                                                        onclick="return confirm('Do you really want to cancel booking')">Cancel</a>
                                                    /
                                                    <a href="manage-live-bookings.php?bckid=<?php echo htmlspecialchars($result->bookid); ?>"
                                                        onclick="return confirm('Booking has been confirmed')">Confirm</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>No bookings found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                <div class="inner-block"></div>
                <?php include('includes/footer.php'); ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</body>

</html>