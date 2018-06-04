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
            <p>Registration done!</p>
        <?php else: ?>
            <form action="#" method="post">
                <h1 class="h1-title">Sign up</h1>
                <input type="text" name="login" placeholder="Login" value="<?php echo $login; ?>" autofocus required>
                <input type="email" name="email" placeholder="E-Mail" value="<?php echo $email; ?>" required>
                <input type="password" name="password" placeholder="Password" value="<?php echo $password; ?>" required>
                <input type="password" name="password_confirm" placeholder="Re-enter password" value="<?php echo $password_confirm; ?>" required>
                <button type="submit" name="submit" value="OK">Sign up</button>
                <p class="p-bottom-text-small">Already have an account? <a href="/user/login">Sign in!</a></p>
            </form>
        <?php endif; ?>
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