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
        $LivePackageId = isset($_GET['lpkgid']) ? intval($_GET['lpkgid']) : 0;
        $user_email = $_SESSION['user_email'] ?? '';
        $RegDate = date('Y-m-d H:i:s');
        $status = 0;
        $CancelledBy = NULL;
        $UpdationDate = NULL;

        if (empty($user_email)) {
            throw new Exception('User email is not set.');
        }

        // Check if the booking already exists
        $check_sql = "SELECT * FROM livebookingtable WHERE LivePackageId = ? AND user_email = ?";
        $check_stmt = $conn->prepare($check_sql);
        if ($check_stmt === false) {
            throw new Exception('Statement preparation failed: ' . $conn->error);
        }
        $check_stmt->bind_param("is", $LivePackageId, $user_email);
        $check_stmt->execute();
        $check_results = $check_stmt->get_result();

        if ($check_results->num_rows > 0) {
            $error = "You have already booked the seat.";
        } else {
            $sql = "INSERT INTO livebookingtable (LivePackageId, user_email, RegDate, status, CancelledBy, UpdationDate) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Statement preparation failed: ' . $conn->error);
            }

            // Bind the parameters
            $stmt->bind_param("ississ", $LivePackageId, $user_email, $RegDate, $status, $CancelledBy, $UpdationDate);

            // Execute the statement
            if ($stmt->execute()) {
                // Redirect to payment page
                $_SESSION['live_booking'] = [
                    'LivePackageId' => $LivePackageId, // Fixed typo here
                    'UserEmail' => $user_email,
                ];
                header('Location: stripe/index.php?lpkgid=' . $LivePackageId);
                exit;
            } else {
                throw new Exception('Execution failed: ' . $stmt->error);
            }
        }
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE HTML>
<html>

<head>
    <title>LVA | Package Details</title>

    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
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
    <!-- navbarend -->






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
                    <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                <?php } else if ($msg) { ?>
                        <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                <?php } ?>

                <?php
                $pid = intval($_GET['lpkgid']);

                // Prepare the SQL statement
                $sql = "SELECT * FROM livestreampackages WHERE LivePackageId=?";
                $stmt = $conn->prepare($sql);

                if ($stmt === false) {
                    die('Prepare failed: ' . $conn->error);
                }

                // Bind parameters
                $stmt->bind_param("i", $pid);

                // Execute the statement
                $stmt->execute();

                // Get the result
                $results = $stmt->get_result();

                if ($results->num_rows > 0) {
                    while ($result = $results->fetch_object()) { ?>

                        <div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
                            <img src="./admin/livestreamimages/<?php echo htmlentities($result->PackageImage); ?>"
                                class="img-responsive" alt="">
                        </div>
                        <div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
                            <h2><?php echo htmlentities($result->PackageType); ?></h2>
                            <p><b>Guest: </b><?php echo htmlentities($result->PackageGuest); ?>
                                <img src="images/verified.png" class="verified-image img-fluid" alt="">
                            </p>
                            <div class="ban-bottom">
                                <div class="bnr-right"></div>
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
                                        <li class="spe" align="center">
                                            <button type="submit" name="submit2" class="btn-primary btn">Book Seat</button>
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