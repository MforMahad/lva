<!DOCTYPE html>
<html>

<head>
    <title>Live Stream</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.css" rel="stylesheet">
    <style>
        #root {
            width: 100vw;
            height: 100vh;
        }
    </style>
</head>

<body>
    <?php
    // Start the session
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        // Redirect to the login page if the user is not logged in
        header('Location: user_Panel.php');
        exit;
    }
    ?>

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

            const roomID = getUrlParams(window.location.href)['roomID'];
            if (!roomID) {
                console.error('roomID is missing in the URL');
                return;
            }

            const appID = 1224875685;
            const serverSecret = "c07260681a8411d9a2dbe5fbddc42d63";
            const userID = "Audience" + Math.floor(Math.random() * 10000);
            const userName = "Audience";

            try {
                const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(appID, serverSecret, roomID, userID, userName);
                const zp = ZegoUIKitPrebuilt.create(kitToken);
                zp.joinRoom({
                    container: document.querySelector("#root"),
                    scenario: {
                        mode: ZegoUIKitPrebuilt.LiveStreaming,
                        config: {
                            role: ZegoUIKitPrebuilt.Audience,
                        },
                    },
                });
            } catch (error) {
                console.error('Error initializing Zego UIKit Prebuilt:', error);
            }
        }
    </script>
</body>

</html>