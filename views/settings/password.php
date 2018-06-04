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
                    <li class="inactive"><a href="/settings/notifications">Notifications</a></li>
                    <li class="active"><a href="/settings/password">Password</a></li>
                </ul>
            </div>
            <div class="main-column">
                <form id="form-settings" action="#" method="post">
                    <div class="info-block">
                        <h2>Password settings</h2>
                        <p class="setting-desc">You can change your password here.</p>
                    </div>
                    <hr>
                    <div class="account-setting">
                        <label for="input-user-curr-pass">Current password:</label>
                        <input id="input-user-curr-pass" type="password" name="current_pass" value="<?php echo $currentPass; ?>" class="input-user">
                    </div>
                    <div class="account-setting">
                        <label for="input-user-new-pass">New password:</label>
                        <input id="input-user-new-pass" type="password" name="new_pass" value="<?php echo $newPass; ?>" class="input-user">
                    </div>
                    <div class="account-setting">
                        <label for="input-user-new-pass-re">Repeat new password:</label>
                        <input id="input-user-new-pass-re" type="password" name="new_pass_re" value="<?php echo $newPassRe; ?>" class="input-user">
                    </div>
                    <div class="bottom-button-section">
                        <button class="btn-settings-confirm btn-enabled" type="submit" name="submit" value="ok">
                            <span>Save</span>
                        </button>
                        <?php if ($error !== false): ?>
                            <p class="p-error-msg"><?php echo $error; ?></p>
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