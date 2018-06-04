<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/template/css/camera.css">
        <title>Camagru - rtarasen</title>
    </head>
    <body>
        <?php include(ROOT . "/views/layouts/header.php"); ?>
        <form action="#" method="post">
            <div id="main">
                <div id="cam-area">
                    <div class="control-buttons">
                        <label for="input-file">Choose your own image  (png/jpeg/gif)</label>
                        <input name="uploaded_img" type="file" id="input-file">
                        <hr>
                        <button id="pause-cam" type="button">Pause</button>
                        <button id="unpause-cam" type="button">Unpause</button>
                    </div>
                    <div id="cam-div"><video id="web-cam" autoplay></video></div>
                    <button id="snap" type="submit"><img id="cam-icon" src="/img/cam-icon.ico"></button>
                </div>
                <div id="overlay-selection">
                    <?php foreach ($overlayList as $overlay):?>
                        <div class="overlay-container">
                            <p class="overlay-name"><?php echo $overlay['name']; ?></p>
                            <label for="ov-<?php echo $overlay['id']; ?>">
                                <img class="overlay-img" src="/<?php echo $overlay['path']; ?>">
                            </label>
                            <input id="ov-<?php echo $overlay['id']; ?>" type="radio" name="overlay" value="<?php echo $overlay['id']; ?>" required>
                        </div>
                    <?php endforeach; ?>
                </div>
                <canvas id="canvas" class="img" width="500" height="375"></canvas>
            </div>
            <div id="user-pictures">
            </div>
        </form>
        <footer>
            <p>author: rtarasen</p>
        </footer>
        <script src="/template/js/camera.js"></script>
    </body>
</html>