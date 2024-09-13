<!doctype html>
<html lang="en">

<head>

    <!-- css links -->
    <?php
    include "repeated/links.php";
    ?>
    <!-- css links end -->



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

                        <h2 class="mb-0">Recorded Streams</h2>
                    </div>

                </div>
            </div>
        </header>



        <section class="latest-podcast-section section-padding pb-0" id="section_2">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-lg-10 col-12">
                        <div class="section-title-wrap mb-5">
                            <h4 class="section-title">Watch</h4>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-12">
                                <div class="custom-block-icon-wrap">
                                    <div class="custom-block-image-wrap custom-block-image-detail-page">
                                        <img src="images/streams/video.jpg" class="custom-block-image img-fluid" alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-9 col-12">
                                <div class="custom-block-info">
                                    <div class="custom-block-top d-flex mb-1">
                                        <small class="me-4">
                                            <a href="#">
                                                <i class="bi-play"></i>
                                                watch now
                                            </a>
                                        </small>

                                        <small>
                                            <i class="bi-clock-fill custom-icon"></i>
                                            50 Minutes
                                        </small>


                                    </div>

                                    <h2 class="mb-2">Mindset</h2>

                                    <p>What is Content Marketing? If you are wondering what content marketing is all
                                        about, this is the place to start.</p>


                                    <div
                                        class="profile-block profile-detail-block d-flex flex-wrap align-items-center mt-5">
                                        <div class="d-flex mb-3 mb-lg-0 mb-md-0">
                                            <img src="images/profile/umair.jpeg" class="profile-block-image img-fluid"
                                                alt="">

                                            <p>
                                                Umair jali wala

                                                <strong>Influencer</strong>
                                            </p>
                                        </div>

                                        <ul class="social-icon ms-lg-auto ms-md-auto">
                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-instagram"></a>
                                            </li>

                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-twitter"></a>
                                            </li>

                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-whatsapp"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <br>
        </section>


        <section class="related-podcast-section section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12">
                        <div class="section-title-wrap mb-5">
                            <h4 class="section-title">Related Streams</h4>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12 mb-4 mb-lg-0">
                        <div class="custom-block custom-block-full">
                            <div class="custom-block-image-wrap">
                                <a href="detail-page.php">
                                    <img src="images/streams/video.jpg" class="custom-block-image img-fluid" alt="">
                                </a>
                            </div>

                            <div class="custom-block-info">
                                <h5 class="mb-2">
                                    <a href="detail-page.php">
                                        Mindset
                                    </a>
                                </h5>

                                <div class="profile-block d-flex">
                                    <img src="images/profile/qasim-ali-shah.jpg" class="profile-block-image img-fluid"
                                        alt="">

                                    <p>Qasim ali Shah
                                        <strong>Influencer</strong>
                                    </p>
                                </div>

                                <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>

                                <div class="custom-block-bottom d-flex justify-content-between mt-3">


                                    <a href="#" class="bi-heart me-1">
                                        <span>2.5k</span>
                                    </a>

                                    <a href="#" class="bi-chat me-1">
                                        <span>924k</span>
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="col-lg-4 col-12 mb-4 mb-lg-0">
                        <div class="custom-block custom-block-full">
                            <div class="custom-block-image-wrap">
                                <a href="detail-page.php">
                                    <img src="images/streams/video.jpg" class="custom-block-image img-fluid" alt="">
                                </a>
                            </div>

                            <div class="custom-block-info">
                                <h5 class="mb-2">
                                    <a href="detail-page.php">
                                        Mindset
                                    </a>
                                </h5>

                                <div class="profile-block d-flex">
                                    <img src="images/profile/qasim-ali-shah.jpg" class="profile-block-image img-fluid"
                                        alt="">

                                    <p>Qasim ali Shah
                                        <strong>Influencer</strong>
                                    </p>
                                </div>

                                <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>

                                <div class="custom-block-bottom d-flex justify-content-between mt-3">


                                    <a href="#" class="bi-heart me-1">
                                        <span>2.5k</span>
                                    </a>

                                    <a href="#" class="bi-chat me-1">
                                        <span>924k</span>
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="col-lg-4 col-12 mb-4 mb-lg-0">
                        <div class="custom-block custom-block-full">
                            <div class="custom-block-image-wrap">
                                <a href="detail-page.php">
                                    <img src="images/streams/video.jpg" class="custom-block-image img-fluid" alt="">
                                </a>
                            </div>

                            <div class="custom-block-info">
                                <h5 class="mb-2">
                                    <a href="detail-page.php">
                                        Mindset
                                    </a>
                                </h5>

                                <div class="profile-block d-flex">
                                    <img src="images/profile/qasim-ali-shah.jpg" class="profile-block-image img-fluid"
                                        alt="">

                                    <p>Qasim ali Shah
                                        <strong>Influencer</strong>
                                    </p>
                                </div>

                                <p class="mb-0">Lorem Ipsum dolor sit amet consectetur</p>

                                <div class="custom-block-bottom d-flex justify-content-between mt-3">


                                    <a href="#" class="bi-heart me-1">
                                        <span>2.5k</span>
                                    </a>

                                    <a href="#" class="bi-chat me-1">
                                        <span>924k</span>
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>





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