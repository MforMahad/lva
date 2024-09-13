<?php
require '../conFile/conection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: user_Panel.php');
    exit;
} else {
    if (isset($_POST['submit6'])) {
        $name = $_POST['name'];
        $email = $_SESSION['user_email']; // Assuming email is stored in the session

        $update_image = false;

        // Check if a file was uploaded
        if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] == UPLOAD_ERR_OK) {
            $update_image = true;

            // Handle file upload
            $target_dir = "../upload/";
            $target_file = $target_dir . basename($_FILES["user_image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a real image
            $check = getimagesize($_FILES["user_image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $msg = "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                $msg = "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["user_image"]["size"] > 500000) {
                $msg = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $msg = "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["user_image"]["tmp_name"], $target_file)) {
                    $msg = "The file " . basename($_FILES["user_image"]["name"]) . " has been uploaded.";
                } else {
                    $msg = "Sorry, there was an error uploading your file.";
                }
            }
        }

        // Update the database with or without the image
        if ($update_image && $uploadOk == 1) {
            $sql = "UPDATE user_reg SET user_name='$name', user_image='$target_file' WHERE user_email='$email'";
        } else {
            $sql = "UPDATE user_reg SET user_name='$name' WHERE user_email='$email'";
        }

        if (mysqli_query($conn, $sql)) {
            $msg = "Profile Updated Successfully";
        } else {
            $msg = "Error updating profile: " . mysqli_error($conn);
            error_log("SQL Error: " . mysqli_error($conn));
        }
    }

    // Retrieve user details based on the logged-in email
    $useremail = $_SESSION['user_email'];

    $sql = "SELECT * FROM user_reg WHERE user_email = '$useremail'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        $row = null;
        echo "No user found with the specified email.";
    }
    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'user-header.php'; ?>


        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #26c2d1;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .profile-container {
                background-color: #ffffff;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                max-width: 500px;
                width: 100%;
                margin: 20px;
                box-sizing: border-box;
            }

            .profile-container h2 {
                margin-bottom: 20px;
                font-size: 28px;
                color: #343a40;
                text-align: center;
                border-bottom: 2px solid #007bff;
                padding-bottom: 10px;
            }

            .profile-container p {
                margin-bottom: 20px;
            }

            .profile-container label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
                color: #495057;
            }

            .profile-container input[type="text"],
            .profile-container input[type="email"] {
                width: 100%;
                padding: 12px;
                border: 1px solid #ced4da;
                border-radius: 4px;
                font-size: 16px;
                color: #495057;
                box-sizing: border-box;
                transition: border-color 0.3s ease;
            }

            .profile-container input[type="text"]:focus,
            .profile-container input[type="email"]:focus {
                border-color: #007bff;
                outline: none;
            }

            .profile-container .btn {
                background-color: #007bff;
                color: white;
                padding: 12px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                width: 100%;
                font-size: 16px;
                font-weight: bold;
                transition: background-color 0.3s ease;
                text-align: center;
            }

            .profile-container .btn:hover {
                background-color: #0056b3;
            }

            .profile-container .msg {
                margin-top: 20px;
                color: green;
                text-align: center;
                font-weight: bold;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .profile-container {
                    padding: 20px;
                }

                .profile-container h2 {
                    font-size: 24px;
                }

                .profile-container input[type="text"],
                .profile-container input[type="email"] {
                    font-size: 14px;
                    padding: 10px;
                }

                .profile-container .btn {
                    font-size: 14px;
                    padding: 10px;
                }
            }

            @media (max-width: 480px) {
                body {
                    padding: 10px;
                }

                .profile-container {
                    padding: 15px;
                    box-shadow: none;
                    border: 1px solid #ced4da;
                }

                .profile-container h2 {
                    font-size: 22px;
                }

                .profile-container input[type="text"],
                .profile-container input[type="email"] {
                    font-size: 13px;
                    padding: 8px;
                }

                .profile-container .btn {
                    font-size: 13px;
                    padding: 8px;
                }
            }
        </style>

    </head>

    <body>
        <!-- Navigation code -->
        <?php include 'navigation.php'; ?>
        <!-- End navigation code -->

        <div class="profile-container">
            <h2>User Profile</h2>

            <?php if (!empty($msg)) {
                echo "<div class='msg'>$msg</div>";
            } ?>

            <form method="POST" enctype="multipart/form-data">
                <p>
                    <label for="name">Name</label>
                    <input type="text" name="name" value="<?php echo htmlentities($row['user_name']); ?>"
                        class="form-control" id="name" required>
                </p>

                <p>
                    <label for="user_image">User Image</label>
                    <input type="file" name="user_image" class="form-control" id="user_image" required>
                </p>

                <p>
                    <label for="email">Email Id</label>
                    <input type="email" class="form-control" name="email"
                        value="<?php echo htmlentities($row['user_email']); ?>" id="email" readonly>
                </p>


                <p>
                    <b>Registration Date:</b> <?php echo htmlentities($row['created_date']); ?>
                </p>

                <p>
                    <button type="submit" name="submit6" class="btn">Update</button>
                </p>
            </form>
        </div>

        <!-- JS for Menu Toggle -->
        <script>

            const menuToggle = document.querySelector('.menuToggle');
            const navigation = document.querySelector('.navigation');
            menuToggle.onclick = function () {
                navigation.classList.toggle('open');
            }

            const list = document.querySelectorAll('.list');
            function activeLink() {
                list.forEach((item) => item.classList.remove('active'));
                this.classList.add('active');
            }
            list.forEach((item) => item.addEventListener('click', activeLink));
        </script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>

    </html>

    <?php
}
?>