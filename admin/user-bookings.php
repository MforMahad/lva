<?php
session_start();
include('includes/config.php');
$error = "";
$msg = "";

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    if (isset($_REQUEST['bkid'])) {
        $bid = intval($_GET['bkid']);
        $status = 2;
        $cancelby = 'a'; // 'a' indicates admin cancelled
        $sql = "UPDATE tblbooking SET status=:status, CancelledBy=:cancelby WHERE BookingId=:bid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':cancelby', $cancelby, PDO::PARAM_STR);
        $query->bindParam(':bid', $bid, PDO::PARAM_INT);
        $query->execute();
        $msg = "Booking Cancelled successfully";
    }

    if (isset($_REQUEST['bckid'])) {
        $bcid = intval($_GET['bckid']);
        $status = 1;
        $sql = "UPDATE tblbooking SET status=:status WHERE BookingId=:bcid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':bcid', $bcid, PDO::PARAM_INT);
        $query->execute();
        $msg = "Booking Confirmed successfully";
    }

    $uid = isset($_GET['uid']) ? $_GET['uid'] : '';
    $uname = isset($_GET['uname']) ? $_GET['uname'] : '';

    if (empty($uid) || empty($uname)) {
        echo "UID: " . htmlentities($uid) . "<br>";
        echo "Username: " . htmlentities($uname) . "<br>";
        echo "UID or Username is missing!";
        exit;
    }

    $sql = "SELECT tblbooking.BookingId as bookid, user_reg.user_name as fname, user_reg.user_email as email, tbltourpackages.PackageName as pckname, tblbooking.PackageId as pid, tblbooking.Comment as comment, tblbooking.status as status, tblbooking.CancelledBy as cancelby, tblbooking.UpdationDate as upddate 
            FROM tblbooking
            LEFT JOIN user_reg ON tblbooking.user_email=user_reg.user_email
            LEFT JOIN tbltourpackages ON tbltourpackages.PackageId=tblbooking.PackageId 
            WHERE user_reg.user_id=:uid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':uid', $uid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
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
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
    </style>
</head>

<body>
    <?php include('includes/sidebarmenu.php'); ?>
    <div class="page-container">
        <div class="left-content">
            <div class="mother-grid-inner">
                <!--header start here-->
                <?php include('includes/header.php'); ?>
                <div class="clearfix"> </div>
            </div>
            <!--header end here-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Manage
                    Bookings</li>
            </ol>
            <div class="agile-grids">
                <!-- tables -->
                <?php if ($error) { ?>
                    <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                <?php } else if ($msg) { ?>
                        <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                <?php } ?>
                <div class="agile-tables">
                    <div class="w3l-table-info">
                        <h2>Manage <?php echo htmlentities($_GET['uname']); ?>'s Bookings</h2>
                        <table id="table">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Name</th>
                                    <th>Email ID</th>
                                    <th>Package</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>
                                        <tr>
                                            <td>#BK-<?php echo htmlentities($result->bookid); ?></td>
                                            <td><?php echo htmlentities($result->fname); ?></td>
                                            <td><?php echo htmlentities($result->email); ?></td>
                                            <td><a
                                                    href="update-package.php?pid=<?php echo htmlentities($result->pid); ?>"><?php echo htmlentities($result->pckname); ?></a>
                                            </td>
                                            <td><?php echo htmlentities($result->comment); ?></td>
                                            <td><?php
                                            if ($result->status == 0) {
                                                echo "Pending";
                                            } elseif ($result->status == 1) {
                                                echo "Confirmed";
                                            } elseif ($result->status == 2) {
                                                if ($result->cancelby == 'a') {
                                                    echo "Canceled by you at " . htmlentities($result->upddate);
                                                } elseif ($result->cancelby == 'u') {
                                                    echo "Canceled by User at " . htmlentities($result->upddate);
                                                }
                                            }
                                            ?></td>
                                            <td><?php
                                            if ($result->status == 2) {
                                                echo "Cancelled";
                                            } elseif ($result->status == 1) {
                                                echo "Confirmed";
                                            } else { ?>
                                                    <a href="manage-bookings.php?bkid=<?php echo htmlentities($result->bookid); ?>"
                                                        onclick="return confirm('Do you really want to cancel booking?')">Cancel</a>
                                                    /
                                                    <a href="manage-bookings.php?bckid=<?php echo htmlentities($result->bookid); ?>"
                                                        onclick="return confirm('Confirm booking?')">Confirm</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php }
                                } else {
                                    echo "<tr><td colspan='7'>No bookings found!</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>