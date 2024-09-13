<?php
require 'conection.php';

#@@@@@@@@@@@@@@@@@@       For Login        @@@@@@@@@@@@@@@@@@@@@@@@@@@@
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session if it's not already active
}

if (isset($_POST['logsubmit'])) {
    $query = "SELECT * FROM `user_reg`  WHERE `user_email`= '$_POST[user_email]' OR `user_name`= '$_POST[user_email]'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {

            $result_fetch = mysqli_fetch_assoc($result);
            if (password_verify($_POST['user_pass'], $result_fetch['user_pass'])) {
                #To check if password matches
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $result_fetch['user_id'];
                $_SESSION['user_name'] = $result_fetch['user_name'];
                $_SESSION['user_email'] = $result_fetch['user_email'];
                $_SESSION['user_image'] = $result_fetch['user_image'];


                header('Location:./index.php');

            } else {
                # if password does not match
                echo "<script> alert('Incorrect password');
                    window.location.href='./index.php';
             </script>";

            }
        } else {
            echo "<script> alert('Email or username is not registered');
                    window.location.href='./index.php';
             </script>";


        }



    } else {
        echo "<script> alert('cannot run query');
                    window.location.href='./index.php';
             </script>";

    }




}


?>

<?php
#@@@@@@@@@@@@@@@@@@       For Registration        @@@@@@@@@@@@@@@@@@@@@@@@@@@@
if (isset($_POST['submit'])) {

    $user_exist_query = "SELECT * FROM `user_reg` WHERE `user_name` ='$_POST[user_name]' OR `user_email` = '$_POST[user_email]'";

    $result = mysqli_query($conn, $user_exist_query);

    if ($result) {

        # it will be executed when the username or email is already registered
        if (mysqli_num_rows($result) > 0) {

            #if users are already taken users or email
            $result = mysqli_fetch_assoc($result);
            if ($result_fetch['user_name'] == $_POST['user_name']) {
                #error for username already registered
                echo "<script> alert('$result_fetch[user_name] - user_name already taken');
                                 window.location.href='./index.php';
                    </script>";
            } else {

                echo "<script> alert('$result_fetch[user_email] - user_email already taken');
                                 window.location.href='./index.php';
                    </script>";


            }

        } else {

            // encrypting the password
            $user_pass = password_hash($_POST['user_pass'], PASSWORD_BCRYPT);

            if (isset($_FILES['user_image']['name'])) {


                $image_name = $_FILES['user_image']['name'];
                $tmp_name = $_FILES['user_image']['tmp_name'];
                $error = $_FILES['user_image']['error'];

                if ($error === 0) {

                    $image_ex = pathinfo($image_name, PATHINFO_EXTENSION);
                    $image_ex_to_lc = strtolower($image_ex);

                    $allowed_exs = array('jpg', 'jpeg', 'png');

                    if (in_array($image_ex_to_lc, $allowed_exs)) {

                        $new_image_name = uniqid($_POST['user_name'], true) . '.' . $image_ex_to_lc;
                        $image_upload_path = './upload/' . $new_image_name;
                        move_uploaded_file($tmp_name, $image_upload_path);

                        //insert into datrabase
                        $date = date('Y-m-d');

                        $query = "INSERT INTO `user_reg`(`user_id` ,`user_image`, `user_name`, `user_email`, `user_pass`, `created_date`) 
                        VALUES ('','$new_image_name','$_POST[user_name]','$_POST[user_email]','$user_pass','$date')";

                        if (mysqli_query($conn, $query)) {
                            #ifdata is inserted successfully
                            echo
                                "<script> alert('Registration successful');
                                    window.location.href='./index.php';
                                 </script>";




                        } else {
                            #if date is not inserted successfully
                            echo
                                "<script> alert('cannot runs Query');
                                    window.location.href='./index.php';
                                </script>";


                        }

                    } else {
                        echo "can't upload this file type";
                        header("Location:./index.php");
                    }

                } else {

                    echo "unknown error occurred";
                    header("Location: ./index.php");
                    exit;

                }


            }

        }

    } else {
        echo
            "<script> alert('cannot run Query');
            window.location.href='./index.php';
        </script>";
    }

}




?>