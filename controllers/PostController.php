<?php

include_once ROOT . '/models/Post.php';
include_once ROOT . '/models/User.php';
include_once ROOT . '/models/Comment.php';
include_once ROOT . '/models/Like.php';

class PostController
{
    public function actionCreate() {

        $userId = User::isLoggedIn();

        if ($userId && isset($_POST['img']) && isset($_POST['overlay'])) {

            $author = User::getUserById($userId);

            if (!empty($_FILES['uploaded_img']) && $_FILES['uploaded_img']['error'] == 0) {

                $userImgInfo = getimagesize($_FILES['uploaded_img']['tmp_name']);
                if (!preg_match("#^(image/)[^\s\n<]+$#i", $userImgInfo['mime'])) {
                    return false;
                }

                $userImgPath = Post::saveUploadedImg($author['login'], $_FILES['uploaded_img']['tmp_name']);
            } else {
                $userImgPath = Post::convertB64Img($author['login'], $_POST['img']);
            }

            $overlay = Post::getOverlayImgById($_POST['overlay']);

            $resultImg = Post::getSuperposedImg($userImgPath, $overlay['path']);

            if ($resultImg === false) {
                return false;
            }

            $resultImgPath = Post::saveSuperposedImg($resultImg, $author['login']);

            Post::create($author['id'], $author['login'], $resultImgPath);

            echo $resultImgPath;

            return true;
        }

        return false;
    }

    public function actionDelete() {

        if (isset($_POST['post_id'])) {
            if ($userId = User::isLoggedIn()) {
                $authorId = User::getUserByPostId($_POST['post_id']);
                if ($userId === $authorId['id']) {
                    Post::deleteImg($_POST['post_id']);
                    Post::delete($_POST['post_id']);
                    Comment::removeAllCommentsByPostId($_POST['post_id']);
                    Like::deleteAllLikesByPostId($_POST['post_id']);
                    echo "true";
                    return true;
                }
            }
        }
        return false;
    }
}