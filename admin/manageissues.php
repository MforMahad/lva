<?php
session_start();
error_reporting(E_ALL); // Ensure all errors are reported
require '../conFile/conection.php';
$error = "";
$msg = "";

// Redirect if user is not logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
} else {
    // Handle issue deletion
    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        $id = intval($_GET['id']);
        $sql = "DELETE FROM tblissues WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo "<script>alert('Record deleted.');</script>";
            echo "<script>window.location.href='manageissues.php'</script>";
        } else {
            echo "<script>alert('Failed to delete record.');</script>";
        }
        $stmt->close();
    }
    ?>

    <!DOCTYPE HTML>
    <html>

    <head>
        <title>LVA | Admin Manage Issues</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="application/x-javascript">
                                            addEventListener("load", function () { setTimeout(hideURLbar, 0); }, false);
                                            function hideURLbar() { window.scrollTo(0, 1); }
                                        </script>
        <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="css/style.css" rel='stylesheet' type='text/css' />
        <link rel="stylesheet" href="css/morris.css" type="text/css" />
        <link href="css/font-awesome.css" rel="stylesheet">
        <script src="js/jquery-2.1.4.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/table-style.css" />
        <link rel="stylesheet" type="text/css" href="css/basictable.css" />
        <script type="text/javascript" src="js/jquery.basictable.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#table').basictable();
                $('#table-breakpoint').basictable({ breakpoint: 768 });
                $('#table-swap-axis').basictable({ swapAxis: true });
                $('#table-force-off').basictable({ forceResponsive: false });
                $('#table-no-resize').basictable({ noResize: true });
                $('#table-two-axis').basictable();
                $('#table-max-height').basictable({ tableWrapper: true });
            });
        </script>
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
        <script language="javascript" type="text/javascript">
            var popUpWin = 0;
            function popUpWindow(URLStr, left, top, width, height) {
                if (popUpWin && !popUpWin.closed) popUpWin.close();
                popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ',top=' + top + ',screenX=' + left + ',screenY=' + top);
            }
        </script>
    </head>

    <body>
        <?php include('includes/sidebarmenu.php'); ?>
        <div class="page-container">
            <!--/content-inner-->
            <div class="left-content">
                <div class="mother-grid-inner">
                    <!--header start here-->
                    <?php include('includes/header.php'); ?>
                    <div class="clearfix"></div>
                </div>
                <!--header end here-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Manage Issues
                    </li>
                </ol>
                <div class="agile-grids">
                    <!-- tables -->
                    <?php if ($error) { ?>
                        <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                    <?php } else if ($msg) { ?>
                            <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                    <?php } ?>
                    <div class="agile-tables">
                        <div class="w3l-table-info">
                            <h2>Manage Issues</h2>
                            <table id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email Id</th>
                                        <th>Issue</th>
                                        <th>Description</th>
                                        <th>Posting Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT tblissues.user_id AS id,
                                                    user_reg.user_name AS fname,
                                                    user_reg.user_email AS email,
                                                    tblissues.Issue AS issue,
                                                    tblissues.Description AS Description,
                                                    tblissues.PostingDate AS PostingDate 
                                            FROM tblissues 
                                            LEFT JOIN user_reg ON user_reg.user_email = tblissues.user_email";

                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td>#00<?php echo htmlentities($row['id']); ?></td>
                                                <td><?php echo htmlentities($row['fname']); ?></td>
                                                <td><?php echo htmlentities($row['email']); ?></td>
                                                <td><?php echo htmlentities($row['issue']); ?></td>
                                                <td><?php echo htmlentities($row['Description']); ?></td>
                                                <td><?php echo htmlentities($row['PostingDate']); ?></td>
                                                <td>
                                                    <a href="javascript:void(0);"
                                                        onClick="popUpWindow('updateissue.php?iid=<?php echo $row['id']; ?>', 100, 100, 600, 600);"
                                                        class="btn btn-primary btn-block">View</a>
                                                    <a href="manageissues.php?action=delete&id=<?php echo $row['id']; ?>"
                                                        onclick="return confirm('Do you really want to delete?')"
                                                        class="btn btn-danger btn-block">Delete</a>
                                                </td>
                                            </tr>
                                        <?php }
                                    }
                                    $stmt->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- script-for sticky-nav -->
                    <script>
                        $(document).ready(function () {
                            var navOffset = $(".header-main").offset().top;
                            $(window).scroll(function () {
                                var scrollPos = $(window).scrollTop();
                                if (scrollPos >= navOffset) {
                                    $(".header-main").addClass("fixed");
                                } else {
                                    $(".header-main").removeClass("fixed");
                                }
                            });
                        });
                    </script>
                    <!-- /script-for sticky-nav -->
                    <!--inner block start here-->
                    <div class="inner-block"></div>
                    <!--inner block end here-->
                    <!--copy rights start here-->
                    <?php include('includes/footer.php'); ?>
                    <!--COPY rights end here-->
                </div>
            </div>
            <!--//content-inner-->
            <!--/sidebar-menu-->


            <div class="clearfix"></div>
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
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/scripts.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
    </body>

    </html>
<?php } ?>