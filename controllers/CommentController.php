<?php

include_once ROOT . '/models/Comment.php';
include_once ROOT . '/models/User.php';
include_once ROOT . '/models/Settings.php';

class CommentController
{
    public function actionAdd()
    {
        if (isset($_POST['post_id']) && isset($_POST['text']) && User::isLoggedIn())
        {
            $postId = $_POST['post_id'];
            $authorId = $_SESSION['user_id'];
            $authorName = $_SESSION['user_login'];
            $commentText = $_POST['text'];

            Comment::addNew($postId, $authorId, $authorName, $commentText);

            $postAuthor = User::getUserByPostId($postId);

            if ($postAuthor !== false && $postAuthor !== $authorId) {
                User::sendEmailNotification($postAuthor, $postId);
            }
            return true;
        }
        return false;
    }

    public function actionRemove()
    {
        if (isset($_POST['comment_id']) && User::isLoggedIn()) {

            $commentId = $_POST['comment_id'];
            Comment::removeById($commentId);
            return true;
        }

        return false;
    }

    public function actionLoad()
    {
        if (isset($_POST['post_id'])) {
            $postAuthor = User::getUserByPostId($_POST['post_id']);
            $commentList = Comment::getCommentListByPostId($_POST['post_id']);
            include(ROOT.'/views/comment/comment-list.php');

            return true;
        }

        return false;
    }
}