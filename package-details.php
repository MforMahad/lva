<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('conFile/conection.php');

$error = "";
$msg = "";

if (isset($_POST['submit2'])) {
    try {
        if (!$conn instanceof mysqli) {
            throw new Exception('Database connection is not established.');
        }

        // Retrieve and sanitize inputs
        $pid = intval($_GET['pkgid']);
        $user_email = $_SESSION['user_email'];
        $comment = $conn->real_escape_string($_POST['comment']);
        $status = 0;

        $checkSql = "SELECT * FROM tblbooking WHERE PackageId=? AND user_email=?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("is", $pid, $user_email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $error = "You have already booked this package.";
        } else {
           
            $sql = "INSERT INTO tblbooking (PackageId, user_email, Comment, status) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bind_param("isss", $pid, $user_email, $comment, $status);

            if ($stmt->execute()) {

                $_SESSION['booking'] = [
                    'PackageId' => $pid,
                    'Comment' => $comment,
                    'UserEmail' => $user_email,
                ];

                $msg = "Booked Successfully. Redirecting to payment...";


                header("Location: stripe/index.php");
                exit;
            } else {
                $error = "Something went wrong. Please try again";
            }

            $stmt->close();
        }
        $checkStmt->close();
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE HTML>
<html>

<head>
    <title>LVA | Package Details</title>
    <?php include "repeated/links.php"; ?>
    <script type="application/x-javascript">
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <?php include "repeated/links.php"; ?>
    <script src="js/jquery-ui.js"></script>

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

    <!-- navbar -->
    <?php include('repeated/navbar.php'); ?>
    <!-- navbar -->

    <!-- top-header -->
    <header class="site-header d-flex flex-column justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 text-center">
                    <h2 class="mb-0">Package Details</h2>
                </div>
            </div>
        </div>
    </header>
    <!-- top-header end-->


    <!-- login-registerforms -->

    <div class="wrapper">
        <span class="icon-close"><ion-icon name="close"></ion-icon></span>

        <div class="form-box login">
            <h2>Login</h2>
            <form action="" method="POST">

                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" name="user_email" required>
                    <label>Email</label>
                </div>

                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="Password" name="user_pass" required>
                    <label>Password</label>
                </div>

                <div class="remember-forgot">
                    <label><input type="checkbox">Remember me</label>
                    <a href="#">Forgot Password</a>
                </div>
                <button type="submit" name="logsubmit" class="btnn">Login</button>

                <div class="login-register">
                    <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
                </div>


            </form>
        </div>

        <!-- Register  -->



        <div class="form-box register">
            <h2>Register</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" name="user_name" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" name="user_email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="Password" name="user_pass" required>
                    <label>Password</label>
                </div>

                <div class="input-box">
                    <br>
                    <input type="file" name="user_image">
                    <label>Profile Picture</label>
                </div>


                <button type="submit" class="btnn" name="submit">Register</button>

                <div class="login-register">
                    <p> Have an account? <a href="#" class="login-link">Login</a></p>
                </div>


            </form>
        </div>

    </div>

    <!-- login-registerforms end -->

    <section class="section section-padding" id="section_2">
        <div class="container">
            <div class="row">

                <?php if ($error) { ?>
                    <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
                <?php } else if ($msg) { ?>
                        <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
                <?php } ?>

                <?php
                $pid = intval($_GET['pkgid']);


                $sql = "SELECT * FROM tbltourpackages WHERE PackageId=?";
                $stmt = $conn->prepare($sql);

                if ($stmt === false) {
                    die('Prepare failed: ' . $conn->error);
                }

                $stmt->bind_param("i", $pid);


                $stmt->execute();

                // Get the result
                $results = $stmt->get_result();

                if ($results->num_rows > 0) {
                    while ($result = $results->fetch_object()) { ?>

                        <div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
                            <img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage); ?>"
                                class="img-responsive" alt="">
                        </div>
                        <div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
                            <h2><?php echo htmlentities($result->PackageName); ?></h2>
                            <p><b>Package Type :</b> <?php echo htmlentities($result->PackageType); ?></p>
                            <p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation); ?></p>
                            <p><b>Gathering Location : </b> <?php echo htmlentities($result->PackageFetures); ?></p>
                            <div class="ban-bottom">
                                <div class="bnr-right">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <h3>Package Details</h3>
                            <p style="padding-top: 1%"><?php echo htmlentities($result->PackageDetails); ?> </p>
                            <div class="clearfix"></div>
                        </div>

                        <?php if ($_SESSION['logged_in']) { ?>
                            <!-- Display booking form only if user is logged in -->
                            <form name="book" method="post">
                                <div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms"
                                    data-wow-delay="500ms">
                                    <ul>
                                        <li class="spe">
                                            <label class="inputLabel">Comment</label>
                                            <input class="special" type="text" name="comment" required="">
                                        </li>

                                        <li class="spe" align="center">
                                            <button type="submit" name="submit2" class="btn-primary btn">Book</button>
                                        </li>
                                    </ul>
                                </div>
                            </form>
                        <?php } else { ?>
                            <ul>
                                <li class="sigi" style="margin-top: 1%">
                                    <a href="#hero-section" class="btn custom-btn">Login to Book</a>
                                </li>
                            </ul>
                        <?php } ?>



                    <?php }
                } ?>
            </div>
        </div>
    </section>

    <!--- /footer-top ---->
    <?php include('repeated/footer.php'); ?>

    <?php include('repeated/jslinks.php'); ?>

    <?php require 'conFile/register.php'; ?>
</body>

</html>