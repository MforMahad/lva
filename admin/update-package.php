<?php
session_start();
error_reporting(0);
include '../conFile/conection.php';

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $pid = intval($_GET['pid']);

    if (isset($_POST['submit'])) {
        $pname = $_POST['packagename'];
        $ptype = $_POST['packagetype'];
        $plocation = $_POST['packagelocation'];
        $pprice = $_POST['packageprice'];
        $pfeatures = $_POST['packagefeatures'];
        $pdetails = $_POST['packagedetails'];
        $pimage = $_FILES["packageimage"]["name"];

        // Update query using MySQLi
        $sql = "UPDATE TblTourPackages 
                SET PackageName=?, PackageType=?, PackageLocation=?, PackagePrice=?, PackageFetures=?, PackageDetails=? 
                WHERE PackageId=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $pname, $ptype, $plocation, $pprice, $pfeatures, $pdetails, $pid);

        if ($stmt->execute()) {
            $msg = "Package Updated Successfully";
        } else {
            $error = "Something went wrong. Please try again.";
        }
    }

    ?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <title>LVA | Admin Package Creation</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords"
            content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
        Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
        <script
            type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
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
            <div class="left-content">
                <div class="mother-grid-inner">
                    <?php include('includes/header.php'); ?>
                    <div class="clearfix"> </div>
                </div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Update Tour
                        Package </li>
                </ol>

                <div class="grid-form">
                    <div class="grid-form1">
                        <h3>Update Package</h3>
                        <?php if ($error) { ?>
                            <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                        <?php } else if ($msg) { ?>
                                <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                        <div class="tab-content">
                            <div class="tab-pane active" id="horizontal-form">
                                <?php
                                $sql = "SELECT * FROM TblTourPackages WHERE PackageId=?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $pid);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_object()) { ?>

                                        <form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control1" name="packagename" id="packagename"
                                                        placeholder="Create Package"
                                                        value="<?php echo htmlentities($row->PackageName); ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Type</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control1" name="packagetype" id="packagetype"
                                                        placeholder=" Package Type eg- Family Package / Couple Package"
                                                        value="<?php echo htmlentities($row->PackageType); ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Location</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control1" name="packagelocation"
                                                        id="packagelocation" placeholder=" Package Location"
                                                        value="<?php echo htmlentities($row->PackageLocation); ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Price in
                                                    PKR</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control1" name="packageprice" id="packageprice"
                                                        placeholder=" Package Price is USD"
                                                        value="<?php echo htmlentities($row->PackagePrice); ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Features</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control1" name="packagefeatures"
                                                        id="packagefeatures"
                                                        placeholder="Package Features Eg-free Pickup-drop facility"
                                                        value="<?php echo htmlentities($row->PackageFetures); ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Details</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" rows="5" cols="50" name="packagedetails"
                                                        id="packagedetails" placeholder="Package Details"
                                                        required><?php echo htmlentities($row->PackageDetails); ?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Image</label>
                                                <div class="col-sm-8">
                                                    <img src="pacakgeimages/<?php echo htmlentities($row->PackageImage); ?>"
                                                        width="200">&nbsp;&nbsp;&nbsp;<a
                                                        href="change-image.php?imgid=<?php echo htmlentities($row->PackageId); ?>">Change
                                                        Image</a>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Last Updation Date</label>
                                                <div class="col-sm-8">
                                                    <?php echo htmlentities($row->UpdationDate); ?>
                                                </div>
                                            </div>
                                        <?php }
                                } ?>
                                    <div class="row">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <button type="submit" name="submit" class="btn-primary btn">Update</button>
                                        </div>
                                    </div>
                            </div>
                            </form>
                            <div class="panel-footer">
                            </div>
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
                    <div class="inner-block">
                    </div>
                    <?php include('includes/footer.php'); ?>

                </div>
            </div>
            <?php include('includes/sidebarmenu.php'); ?>
            <div class="clearfix"> </div>
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