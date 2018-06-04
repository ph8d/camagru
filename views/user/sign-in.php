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
            <form action="#" method="post">
                <h1 class="h1-title">Sign in</h1>
                <input type="text" name="login" placeholder="Login" autofocus required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="submit" value="OK">Sign in</button>
                <p class="p-bottom-text-small">Forgot your password? <a href="/user/recovery">Reset it!</a></p>
                <p class="p-bottom-text-small">Don't have an account? <a href="/user/register">Sign up!</a></p>
            </form>
        </div>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul class="error-list">
                <?php foreach ($errors as $error): ?>
                    <li>- <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </body>
</html>