<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../conFile/conection.php';

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
}

$pid = intval($_GET['p__id']); // Ensure 'p__id' is passed in the URL

$error = "";
$msg = "";

if (isset($_POST['submit'])) {
    $pname = isset($_POST['PackageName']) ? $_POST['PackageName'] : '';
    $ptype = isset($_POST['PackageType']) ? $_POST['PackageType'] : '';
    $pprice = isset($_POST['packageprice']) ? $_POST['packageprice'] : '';
    $pdetails = isset($_POST['packagedetails']) ? $_POST['packagedetails'] : '';
    $pimage = isset($_FILES["packageimage"]["name"]) ? $_FILES["packageimage"]["name"] : '';
    $pimage_tmp = isset($_FILES["packageimage"]["tmp_name"]) ? $_FILES["packageimage"]["tmp_name"] : '';

    if ($pimage) {
        $pimage_path = "livestreamimages/" . basename($pimage);
        move_uploaded_file($pimage_tmp, $pimage_path);

        $sql = "UPDATE livestreampackages
                SET PackageName=?, PackageType=?, PackagePrice=?, PackageDetails=?, PackageImage=? 
                WHERE LivePackageId=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("sssssi", $pname, $ptype, $pprice, $pdetails, $pimage, $pid);
    } else {
        $sql = "UPDATE livestreampackages 
                SET PackageName=?, PackageType=?, PackagePrice=?, PackageDetails=? 
                WHERE LivePackageId=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("ssssi", $pname, $ptype, $pprice, $pdetails, $pid);
    }

    if ($stmt->execute()) {
        $msg = "Live Package Updated Successfully";
    } else {
        $error = "Something went wrong. Please try again.";
    }
    $stmt->close();
}

$sql = "SELECT * FROM livestreampackages WHERE LivePackageId=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pid);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_object();
$stmt->close();
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>LVA | Admin Live Package Update</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Responsive web template, Bootstrap Web Templates" />
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
    <div class="page-container">
        <div class="left-content">
            <div class="mother-grid-inner">
                <?php include('includes/header.php'); ?>
                <div class="clearfix"> </div>
            </div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Update Live
                    Package</li>
            </ol>

            <div class="grid-form">
                <div class="grid-form1">
                    <h3>Update Live Package</h3>
                    <?php if ($error) { ?>
                        <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                    <?php } else if ($msg) { ?>
                            <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                    <?php } ?>
                    <div class="tab-content">
                        <div class="tab-pane active" id="horizontal-form">
                            <form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label">Package Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control1" name="PackageName" id="packagename"
                                            placeholder="Create Package"
                                            value="<?php echo htmlentities($row->PackageName); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label">Package Type</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control1" name="PackageType" id="packagetype"
                                            placeholder="Package Type eg- Family Package / Couple Package"
                                            value="<?php echo htmlentities($row->PackageType); ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label">Package Price in
                                        PKR</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control1" name="packageprice" id="packageprice"
                                            placeholder="Package Price in PKR"
                                            value="<?php echo htmlentities($row->PackagePrice); ?>" required>
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
                                        <img src="livestreamimages/<?php echo htmlentities($row->PackageImage); ?>"
                                            width="200">
                                        &nbsp;&nbsp;&nbsp;<a
                                            href="change-image.php?imgid=<?php echo htmlentities($row->LivePackageId); ?>">Change
                                            Image</a>
                                        <input type="file" name="packageimage" id="packageimage">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="focusedinput" class="col-sm-2 control-label">Last Updation Date</label>
                                    <div class="col-sm-8">
                                        <?php echo htmlentities($row->UpdationDate); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        <button type="submit" name="submit" class="btn-primary btn">Update</button>
                                    </div>
                                </div>
                            </form>
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

                <script src="js/jquery.nicescroll.js"></script>
                <script src="js/scripts.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <div class="inner-block">
                </div>
                <?php include('includes/footer.php'); ?>

            </div>
            <?php include('includes/sidebarmenu.php'); ?>
            <div class="clearfix"> </div>
        </div>

</body>

</html>