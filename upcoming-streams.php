<?php
session_start();
error_reporting(0);
include('conFile/conection.php'); // Ensure this file establishes a mysqli connection

?>

<!doctype html>
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



        <header class="site-header d-flex flex-column justify-content-center align-items-center">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12 text-center">

                        <h2 class="mb-0">Live Seminars</h2>
                    </div>

                </div>
            </div>
        </header>




        <section class="section section-padding" id="section_2">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12">
                        <div class="section-title-wrap mb-5">
                            <h4 class="section-title">Latest Streams</h4>
                        </div>
                    </div>
                    <?php
                    // Query to select all live stream packages
                    $sql = "SELECT * FROM livestreampackages";
                    $result = $conn->query($sql);

                    // Check if the query was successful
                    if ($result === false) {
                        die("Query failed: " . $conn->error);
                    }

                    // Fetch all results
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_object()) {
                            ?>
                            <div class=" col-12 mb-4 mb-lg-0 itemvid  video-fil" data-category="productivity">
                                <div class="custom-block d-flex">
                                    <div class="">
                                        <div class="custom-block-icon-wrap">
                                            <div class="section-overlay"></div>
                                            <a href="detail-page.php" class="custom-block-image-wrap">
                                                <img width: 113px !important;
                                                    src="./admin/livestreamimages/<?php echo htmlentities($row->PackageImage); ?>"
                                                    class="custom-block-image img-fluid" alt="">

                                                <a href="#" class="custom-block-icon">
                                                    <i class="bi-play-fill"></i>
                                                </a>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="custom-block-info">
                                        <h5 class="mb-2">
                                            <a href="details.php">
                                                <?php echo htmlentities($row->PackageType); ?>
                                            </a>
                                        </h5>

                                        <div class="profile-block d-flex">
                                            <p>
                                                <b>Guest: </b><?php echo htmlentities($row->PackageGuest); ?>
                                                <img src="images/verified.png" class="verified-image img-fluid" alt="">
                                            </p>
                                        </div>

                                        <p class="mb-0"><?php echo htmlentities($row->PackageDetails); ?></p>

                                        <div class="custom-block-bottom d-flex justify-content-between mt-3">


                                            <div class="mt-2">
                                                <a href="livestream-details.php?lpkgid=<?php echo htmlentities($row->LivePackageId); ?>"
                                                    class="btn custom-btn">
                                                    watch
                                                </a>
                                            </div>
                                            <div class="mt-2">
                                                <a href="" class="fa-regular fa-rupee-sign me-1">
                                                    <span>PKR<?php echo htmlentities($row->PackagePrice); ?></span>
                                                </a>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>

                            <?php
                        }
                    }

                    // Free result set
                    $result->free();

                    // Close the connection
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