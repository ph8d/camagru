<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/template/css/view.css">
        <title>Camagru - rtarasen</title>
    </head>
    <body>
        <?php include(ROOT . "/views/layouts/header.php"); ?>
        <div id="main">
            <div id="post">
                <div id="post-main-section">
                    <p><?php echo $galleryItem['author_name'];?> <span id="post-date"><?php echo $galleryItem['date'];?></span></p>
                    <img src="/<?php echo $galleryItem['img']; ?>">
                </div>
                <div id="post-top-action-section">

                    <button class="top-action-btn like" data-post-id="<?php echo $galleryItem['id']; ?>">
                        <?php if ($isLiked === true): ?>
                            <img src="/img/heart-shape-silhouette.svg">
                        <?php else: ?>
                            <img src="/img/heart.svg">
                        <?php endif; ?>
                    </button>

                    <button class="top-action-btn comments"></button>

                    <?php if ($currentUserId === $galleryItem['author_id']): ?>
                        <button class="top-action-btn delete"></button>
                    <?php endif; ?>

                </div>
                <span id="like-count">Likes <?php echo $galleryItem['likes'];?></span>

                <div id="post-comment-section" style="display: none;">
                    <hr id="list-divider">
                    <div id="post-comment-container">
                        <ul id="post-list-of-comments">
                        </ul>
                    </div>
                </div>

                <hr id="list-divider">
                <form id="post-bottom-action-section" action="#">
                    <textarea aria-label="Add a comment..." placeholder="Add a comment..." autocomplete="off" style="height: 22px;"></textarea><button type="button" id="add-comment" data-post-id="<?php echo $galleryItem['id']; ?>"><img src=""></button>
                </form>
            </div>
        </div>
        <script src="/template/js/galleryView.js"></script>
        <footer>
            <p>author: rtarasen</p>
        </footer>
    </body>
</html>