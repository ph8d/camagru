<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/template/css/sign-in.css">
        <title>Camagru - rtarasen</title>
    </head>
    <body>
        <?php include(ROOT . "/views/layouts/header.php"); ?>
        <div class="form-main">
            <?php if (isset($result)): ?>
                <p>Password was successfully reset!</p>
            <?php else: ?>
                <form action="#" method="post">
                    <h1 class="h1-title">New password</h1>
                    <input type="password" name="password" placeholder="Password" value="<?php echo $password; ?>" required> <br>
                    <input type="password" name="password_re" placeholder="Re-enter password" value="<?php echo $password_re; ?>" required> <br>
                    <button type="submit" name="submit" value="OK">Save</button>
                    <?php if ($error !== false): ?>
                        <p class="p-error-msg"><?php echo $error; ?></p>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </div>
    </body>
</html>