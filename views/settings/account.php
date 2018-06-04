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
                    <li class="active"><a href="/settings/account">Account</a></li>
                    <li class="inactive"><a href="/settings/notifications">Notifications</a></li>
                    <li class="inactive"><a href="/settings/password">Password</a></li>
                </ul>
            </div>
            <div class="main-column">
                <form id="form-settings" action="#" method="post">
                    <div class="info-block">
                        <h2>Account settings</h2>
                        <p class="setting-desc">You can change your account information here.</p>
                    </div>
                    <hr>
                    <div class="account-setting">
                        <label for="input-user-login">Your login</label>
                        <input id="input-user-login" type="text" name="new_login" value="<?php echo $login; ?>" class="input-user">
                        <button class="btn-settings-confirm btn-enabled" type="submit" name="submit_login" value="ok">
                            <span>Save</span>
                        </button>
                        <?php if ($loginError !== false): ?>
                            <p class="p-error-msg"><?php echo $loginError; ?></p>
                        <?php endif; ?>
                    </div>
                    <hr>
                    <div class="account-setting">
                        <label for="input-user-email">Your email</label>
                        <input id="input-user-email" type="email" name="new_email" value="<?php echo $email; ?>" class="input-user">
                        <button class="btn-settings-confirm btn-enabled" type="submit" name="submit_email" value="ok">
                            <span>Save</span>
                        </button>
                        <?php if ($emailError !== false): ?>
                            <p class="p-error-msg"><?php echo $emailError; ?></p>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        <footer>
            <p>author: rtarasen</p>
        </footer>
    </body>
</html>