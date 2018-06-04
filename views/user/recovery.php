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
            <?php if (isset($result) && $result === true): ?>
                <p>Account recovery link was sent to your email!</p>
            <?php else: ?>
                <form action="#" method="post">
                    <h1 class="h1-title">Recovery</h1>
                    <input type="email" name="email" placeholder="Email" autofocus required>
                    <button type="submit" name="submit" value="OK">Send recovery email</button>
                </form>
            <?php endif; ?>
        </div>
        <?php if ($error !== false): ?>
            <p class="p-error-msg"><?php echo $error; ?></p>
        <?php endif; ?>
    </body>
</html>