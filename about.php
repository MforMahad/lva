<!doctype html>
<html lang="en">

<head>

    <?php
    include "repeated/links.php";
    ?>

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

                        <h2 class="mb-0">About LVA</h2>
                    </div>

                </div>
            </div>
        </header>


        <section class="about-section section-padding" id="section_2">
            <div class="container">
                <div class="row">

                    <div class="col-lg-8 col-12 mx-auto">
                        <div class="pb-5 mb-5">
                            <div class="section-title-wrap mb-4">
                                <h4 class="section-title">Our story</h4>
                            </div>

                            <p>At LVA, we believe that education should be accessible, engaging, and tailored to your
                                unique interests.
                                Our platform streamlines the entire process, making it effortless for you to discover,
                                book, and attend a diverse range of educational experiences. Whether you're a student
                                looking for scholarships, an institution organizing events,
                                or a curious learner seeking new adventures, LVA has something extraordinary for
                                everyone</p>

                            <p>Embark on a journey of knowledge and discovery with Learning Voyage Adventure (LVA), your
                                gateway to a world of educational events, seminars, scholarships, and enriching trips.
                                LVA is more than just a platform;
                                it's a comprehensive solution designed to revolutionize the way you engage with learning
                                opportunities.</p>

                            <img src="images/medium-shot-young-people-recording-podcast.jpg"
                                class="about-image mt-5 img-fluid" alt="">


                            <p></p>
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