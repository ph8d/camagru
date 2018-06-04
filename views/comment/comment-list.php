<?php if (isset($commentList) && isset($commentList['0'])): ?>
    <hr id="list-divider">
    <div id="post-comment-container">
        <ul id="post-list-of-comments">
            <?php foreach ($commentList as $comment): ?>
                <li class="comment">
                    <?php if (isset($_SESSION['user_id']) && ($comment['author_id'] === $_SESSION['user_id'] || $postAuthor['id'] === $_SESSION['user_id'])): ?>
                        <button class="btn-delete-comment" title="Delete comment" data-comment-id="<?php echo $comment['id']; ?>"></button>
                    <?php endif; ?>
                    <span class="comment-author"><?php echo $comment['author_name']; ?></span>
                    <span class="comment-text"><?php echo $comment['text']; ?></span>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif; ?>