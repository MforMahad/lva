<div class="navigation">
    <div class="menuToggle"></div>

    <!-- image code -->

    <img class="img-fluid rounded-circle" src='../upload/<?= $_SESSION['user_image'] ?>'>

    <!--image end -->

    <ul>

        <!-- <li class="list active" style="--clr:#f44336;">
            <a href="#">
                <span class="icon"><i class="bi bi-bell"></i></span>
                <span class="text">Notifications</span>
            </a>
        </li> -->
        <br>
        <br>
        <br>
        <li class="list" style="--clr:#0fc70f;">
            <a href="../Index.php">
                <span class="icon"><i class="bi bi-house"></i></span>
                <span class="text">Home</span>
            </a>
        </li>

        <li class="list" style="--clr:#0fc70f;">
            <a href="profile.php">
                <span class="icon"><i class="bi bi-person"></i></span>
                <span class="text">Profile</span>
            </a>
        </li>

        <li class="list" style="--clr:#0fc70f;">
            <a href="live-link.php">
                <span class="icon"><i class="bi bi-camera"></i></span>
                <span class="text">Live Link</span>
            </a>
        </li>

        <li class="list" style="--clr:#0fc70f;">
            <a href="change-password.php">
                <span class="icon"><i class="bi bi-lock"></i></span>
                <span class="text">Password</span>
            </a>
        </li>

        <li class="list" style="--clr:#0fc70f;">
            <a href="tour-history.php">
                <span class="icon"><i class="bi bi-gear"></i></span>
                <span class="text">Tour History</span>
            </a>
        </li>

        <li class="list" style="--clr:#0fc70f;">
            <a href="change-password.php">
                <span class="icon"><i class="bi bi-lock"></i></span>
                <span class="text">Password</span>
            </a>
        </li>

        <li class="list " style="--clr:#ffa117;">
            <a href="payment-history.php">
                <span class="icon"><i class="bi bi-credit-card-2-back"></i></span>
                <span class="text">Payments</span>
            </a>
        </li>



        <li class="list" style="--clr:#0fc70f;">
            <a href="write-us.php">
                <span class="icon"><i class="bi bi-question"></i></i></span>
                <span class="text">Any queries</span>
            </a>
        </li>








        <li class="list logout" style="--clr:#0fc70f;">
            <a href="#">
                <span class="icon"><ion-icon name="log-out-outline"></ion-icon></i></span>
                <span class="text">Logout
                    <?php
                    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                        echo "<div class='user'> <a href=' ../conFile/logout.php' style=' background-color: #ffffff00; box-sizing: border-box;padding:
                            10px 20px 10px 8px;padding-left:22px ; padding-bottom:20px; border-radius: .9rem; margin-top: -40px;
                            z-index: ;'></a></div>";




                    } else {
                        header('Location: ../index.php');
                        ;
                    }



                    ?>
                </span>
            </a>
        </li>


    </ul>




</div>