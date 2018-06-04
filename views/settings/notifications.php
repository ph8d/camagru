<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/template/css/settings.css">
        <title>Camagru - rtarasen</title>
    </head>
    <body>
        <?php include(ROOT . "/views/layouts/header.php"); ?>
        <div class="container">
            <div class="navigation-column">
                <ul>
                    <li class="inactive"><a href="/settings/account">Account</a></li>
                    <li class="active"><a href="/settings/notifications">Notifications</a></li>
                    <li class="inactive"><a href="/settings/password">Password</a></li>
                </ul>
            </div>
            <div class="main-column">
                <form id="form-settings" action="#" method="post">
                    <div class="info-block">
                        <h2>Notification settings</h2>
                        <p class="setting-desc">You can change your notification settings here.</p>
                    </div>
                    <hr>

                    <?php foreach ($userSettings as $property):?>
                        <div class="notification-setting">

                            <input type="hidden" name="<?php echo $property['id']; ?>" value="0">

                            <?php if ($property['value'] === "1"): ?>
                                <input id="<?php echo $property['name']; ?>" type="checkbox" name="<?php echo $property['id']; ?>" value="1" checked>
                            <?php else: ?>
                                <input type="checkbox" id="<?php echo $property['name']; ?>" name="<?php echo $property['id']; ?>" value="1">
                            <?php endif; ?>

                            <label for="<?php echo $property['name']; ?>"><?php echo $property['label']; ?></label>
                            <p class="setting-desc"><?php echo $property['description']; ?></p>
                        </div>
                    <?php endforeach;?>

                    <hr>
                    <div class="bottom-button-section">
                        <button class="btn-settings-confirm btn-enabled" type="submit" name="submit" value="ok">
                            <span>Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <footer>
            <p>author: rtarasen</p>
        </footer>
        <script src="/template/js/settings.js"></script>
    </body>
</html>