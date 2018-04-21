<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/sign-in.css">
        <title>Camagru - rtarasen</title>
    </head>
    <body>
        <?php include("header.php"); ?>
        <div class="form-main">
            <form action="scripts/login.php" method="post">
                <h1 class="h1-title">Sign in</h1>
                <input type="text" name="login" placeholder="Login" autofocus required> <br>
                <input type="password" name="passwd" placeholder="Password" required> <br>
                <button type="submit" name="submit" value="OK">Sign in</button>
                <p class="p-bottom-text-small">Forgot your password? <a href="passwd-reset.php">Reset it!</a></p>
                <p class="p-bottom-text-small">New customer? <a href="sign-up.php">Sign up!</a></p>
            </form>
        </div>
    </body>
</html>