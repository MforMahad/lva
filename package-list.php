<?php
session_start();
error_reporting(0);
include('conFile/conection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include "repeated/links.php";
    ?>

    <script type="application/x-javascript">
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
        function hideURLbar(){ window.scrollTo(0,1); } 
    </script>
    <script>
        new WOW().init();
    </script>
</head>

<body>

    <main>

        <!-- navbar code -->

        <?php
        include "repeated/navbar.php";
        ?>

        <!-- navbar code end -->

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

        <header class="site-header d-flex flex-column justify-content-center align-items-center">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12 text-center">

                        <h2 class="mb-0"> Events</h2>
                    </div>

                </div>
            </div>
        </header>



        <section class="section section-padding" id="section_2">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12">
                        <div class="section-title-wrap mb-5">
                            <h4 class="section-title">Package List</h4>
                        </div>
                    </div>



                    <?php
                    // Query to select all tour packages
                    $sql = "SELECT * FROM tbltourpackages";
                    $result = $conn->query($sql);

                    // Check if query was successful
                    if ($result === false) {
                        die("Query failed: " . $conn->error);
                    }

                    // Fetch all results
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_object()) {
                            ?>

                            <div class=col-12 mb-4 mb-lg-0 itemvid video-fil" data-category="education">
                                <div class="custom-block d-flex">
                                    <div class="">
                                        <div class="custom-block-icon-wrap">
                                            <img src="./admin/pacakgeimages/<?php echo htmlentities($row->PackageImage); ?>"
                                                class="custom-block-image img-fluid" alt="">
                                        </div>
                                    </div>

                                    <div class="custom-block-info">
                                        <h5 class="mb-2">
                                            <a href="details.php">
                                                <?php echo htmlentities($row->PackageName); ?>
                                            </a>
                                        </h5>

                                        <div class="profile-block d-flex">
                                            <p>
                                                <b>Package Location :</b> <?php echo htmlentities($row->PackageLocation); ?>

                                            </p>
                                        </div>
                                        <div class="profile-block d-flex">
                                            <p>
                                                <b>Package Type :<?php echo htmlentities($row->PackageType); ?>

                                            </p>
                                        </div>

                                        <p class="mb-0"><?php echo htmlentities($row->PackageDetails); ?></p>

                                        <div class="custom-block-bottom d-flex justify-content-between mt-3">


                                            <div class="mt-2">
                                                <a href="package-details.php?pkgid=<?php echo htmlentities($row->PackageId); ?>"
                                                    class="btn custom-btn">
                                                    Details
                                                </a>
                                            </div>
                                            <div class="mt-2">
                                                <a href="" class="fa-regular fa-rupee-sign me-1">
                                                    <span>PKR <?php echo htmlentities($row->PackagePrice); ?></span>
                                                </a>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>

                            <?php
                        }
                    }

                   
                    $result->free();

                    $conn->close();
                    ?>

                </div>
            </div>
        </section>
    </main>



    <!-- footercode -->
    <?php
    include 'repeated/footer.php';
    ?>
    <!-- footercode end -->

    <!-- javaScript links -->

    <?php
    include 'repeated/jslinks.php';
    ?>

    <!-- javaScript links end -->

</body>

</html>