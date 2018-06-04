<link rel="stylesheet" type="text/css" href="/template/css/header.css">
<link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab" rel="stylesheet">

<header class="header-main">
    <nav class="menu">
        <a href="/"><button id="logo-btn">Camagru!</button></a>
        <a href="/gallery"><button>Gallery</button></a>
        <?php if (isset($_SESSION['user_login'])): ?>
            <div id="drop-down-list">
                <button id="login-btn"><?php echo $_SESSION['user_login']; ?></button>
                <div id="list-content">
                    <a href="/settings/account"><button>Settings</button></a>
                    <hr class="list-divider">
                    <a href="/user/logout"><button>Logout</button></a>
                </div>
            </div>
        <?php else: ?>
            <div id="drop-down-list">
                <a href="/user/login"><button id="login-btn">Login</button></a>
            </div>
        <?php endif; ?>
    </nav>
</header>