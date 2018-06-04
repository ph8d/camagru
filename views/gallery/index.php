<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/template/css/gallery.css">
        <title>Camagru - rtarasen</title>
    </head>
    <body>
        <?php include(ROOT . "/views/layouts/header.php"); ?>
        <a href="/gallery/camera"><button id="new-photo"><img id="cam-icon" src="/img/cam-icon.ico"></button></a>

        <div id="main">
            <?php foreach ($galleryList as $galleryItem):?>
                <div class="post">
                    <a class="author-id" href="/gallery/user/<?php echo $galleryItem['author_id'];?>"><?php echo $galleryItem['author_name'];?></a>
                    <div class="img"><img src="/<?php echo $galleryItem['img']; ?>"></div>
                    <div class="action-buttons">
                        <button class="<?php echo $galleryItem['class_name']; ?>" data-post-id="<?php echo $galleryItem['id']; ?>"><span id="like-count">Like <?php echo $galleryItem['likes'];?></span></button><a href="<?php echo '/gallery/post/'.$galleryItem['id'];?>"><button class="comment">Open</button></a>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <div class="pagination-container">
            <div class="pagination">
                <?php if ($page - 1 >= 1): ?>
                    <a href="/gallery/<?php echo $action . ($page - 1); ?>">&#10094;</a>
                <?php endif; ?>
                <a class="curr-page"><?php echo $page; ?></a>
                <?php if ($page + 1 <= $totalPages): ?>
                    <a href="/gallery/<?php echo $action . ($page + 1); ?>">&#10095;</a>
                <?php endif; ?>
            </div>
        </div>
        <script src="/template/js/galleryIndex.js"></script>
        <footer>
            <p>author: rtarasen</p>
        </footer>
    </body>
</html>