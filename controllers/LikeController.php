<?php

include_once ROOT . '/models/Like.php';
include_once ROOT . '/models/User.php';


class LikeController
{

    public function actionToggle()
    {
        if (($userId = User::isLoggedIn()) && isset($_POST['post_id'])) {

            if (Like::isPostAlreadyLiked($userId, $_POST['post_id'])) {
                Like::remove($userId, $_POST['post_id']);
                echo "0";
            } else {
                Like::add($userId, $_POST['post_id']);
                echo "1";
            }
            return true;
        }
        return false;
    }

    public function actionCount()
    {
        if (isset($_POST['post_id'])) {
            echo Like::countLikesByPostId($_POST['post_id']);
            return true;
        }

        return false;
    }

}