<?php
require '../conFile/conection.php';
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>LVA | Admin Live Stream</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="application/x-javascript">
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar() { window.scrollTo(0,1); }
    </script>
    <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="css/morris.css" type="text/css" />
    <link href="css/font-awesome.css" rel="stylesheet">
    <script src="js/jquery-2.1.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/table-style.css" />
    <link rel="stylesheet" type="text/css" href="css/basictable.css" />
    <script type="text/javascript" src="js/jquery.basictable.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').basictable();
            $('#table-breakpoint').basictable({ breakpoint: 768 });
            $('#table-swap-axis').basictable({ swapAxis: true });
            $('#table-force-off').basictable({ forceResponsive: false });
            $('#table-no-resize').basictable({ noResize: true });
            $('#table-two-axis').basictable();
            $('#table-max-height').basictable({ tableWrapper: true });
        });
    </script>
    <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet'
        type='text/css' />
    <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />

    <style>
        #root {
            padding-top: 2px;
            width: 80vw;
            height: 80vh;
            padding-left: 30%;
            padding-bottom: 2px;
        }

        .BYpXSnOHfrC2td4QRijO {
            width: 100%;
            height: 100%;
        }
    </style>

    <script language="javascript" type="text/javascript">
        var popUpWin = 0;
        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin && !popUpWin.closed) popUpWin.close();
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ',top=' + top + ',screenX=' + left + ',screenY=' + top);
        }
    </script>
</head>

<body>
    <?php
    // Retrieve role from query parameters
    $role = isset($_GET['role']) ? $_GET['role'] : '';

    // If the role is Audience, redirect to a different page
    if ($role === 'Audience') {
        header("Location: http://localhost:8080/lva/userPanel/user-view.php?roomID=" . $roomID);
        exit();
    }
    ?>

    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebarmenu.php'); ?>
    <div id="root"></div>

    <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
    <script>
        window.onload = function () {
            function getUrlParams(url) {
                let urlStr = url.split('?')[1];
                const urlSearchParams = new URLSearchParams(urlStr);
                const result = Object.fromEntries(urlSearchParams.entries());
                return result;
            }

            // Generate a Token by calling a method.
            // @param 1: appID
            // @param 2: serverSecret
            // @param 3: Room ID
            // @param 4: User ID
            // @param 5: Username
            const roomID = getUrlParams(window.location.href)['roomID'] || (Math.floor(Math.random() * 10000) + "");
            const userID = Math.floor(Math.random() * 10000) + "";
            const userName = "userName" + userID;
            const appID = 1224875685;
            const serverSecret = "c07260681a8411d9a2dbe5fbddc42d63";
            const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(appID, serverSecret, roomID, userID, userName);

            // You can assign different roles based on url parameters.
            let role = getUrlParams(window.location.href)['role'] || 'Host';
            role = role === 'Host' ? ZegoUIKitPrebuilt.Host : ZegoUIKitPrebuilt.Audience;
            let config = {}
            if (role === 'Host') {
                config = {
                    turnOnCameraWhenJoining: true,
                    showMyCameraToggleButton: true,
                    showAudioVideoSettingsButton: true,
                    showScreenSharingButton: false,
                    showTextChat: true,
                    showUserList: true,
                }
            }
            const zp = ZegoUIKitPrebuilt.create(kitToken);
            zp.joinRoom({
                container: document.querySelector("#root"),
                scenario: {
                    mode: ZegoUIKitPrebuilt.LiveStreaming,
                    config: {
                        role,
                    },
                },
                sharedLinks: [{
                    name: 'Join as an audience',
                    url:
                        'http://localhost:8080/lva/userPanel/user-view.php' +
                        '?roomID=' +
                        roomID +
                        '&role=Audience',
                }],
                ...config
            });
        }
    </script>

    <!-- sidebar code -->
    <script>
        var toggle = true;
        $(".sidebar-icon").click(function () {
            if (toggle) {
                $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
                $("#menu span").css({ "position": "absolute" });
            } else {
                $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
                setTimeout(function () {
                    $("#menu span").css({ "position": "relative" });
                }, 400);
            }
            toggle = !toggle;
        });
    </script>
    <!-- footer -->
    <div class="inner-block"></div>
    <?php include('includes/footer.php'); ?>
    <!-- footer end -->
    <!--js -->
    <!-- <script src="js/jquery.nicescroll.js"></script> -->
    <script src="js/scripts.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>