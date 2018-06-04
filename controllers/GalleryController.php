<?php

include_once ROOT . '/models/Gallery.php';
include_once ROOT . '/models/User.php';
include_once ROOT . '/models/Comment.php';
include_once ROOT . '/models/Like.php';

class GalleryController
{
    public function actionIndex($page = 1)
    {
        $action = '';
        $galleryList = array();
        $galleryList = Gallery::getGalleryList($page);

        if (isset($galleryList['0']) || $page === 1) {

            if ($userId = User::isLoggedIn()) {
                foreach ($galleryList as $i => $item) {
                    if (Like::isPostAlreadyLiked($userId, $item['id'])) {
                        $galleryList[$i]['class_name'] = "like liked";
                    }
                }
            }

            $totalPages = Gallery::getTotalPages();

            require_once(ROOT.'/views/gallery/index.php');

        } else {
            require_once(ROOT . '/views/error/404.php');
            header("Refresh:2; /");
        }

        return true;
    }

    public function actionView($id)
    {
        if ($id) {
            if ($galleryItem = Gallery::getGalleryItemById($id)) {

                if ($currentUserId = User::isLoggedIn()) {
                    $isLiked = Like::isPostAlreadyLiked($currentUserId, $id);
                } else {
                    $isLiked = false;
                }
                $commentList = Comment::getCommentListByPostId($id);
                require_once(ROOT.'/views/gallery/view.php');

            } else {
                require_once(ROOT . '/views/error/404.php');
                header("Refresh:3; /");
            }
        }
        return true;
    }

    public function actionUser($userId, $page = 1)
    {
        $action = 'user/' . $userId . '/';
        $galleryList = array();
        $galleryList = Gallery::getGalleryListByUserId($userId, $page);

        if (isset($galleryList['0'])) {

            if ($userId = User::isLoggedIn()) {
                foreach ($galleryList as $i => $item) {
                    if (Like::isPostAlreadyLiked($userId, $item['id'])) {
                        $galleryList[$i]['class_name'] = "like liked";
                    }
                }
            }

            $totalPages = Gallery::getTotalPagesByUserId($userId);

            require_once(ROOT.'/views/gallery/index.php');
        } else {
            require_once(ROOT . '/views/error/404.php');
            header("Refresh:3; /");
        }

        return true;
    }

    public function actionCamera()
    {
        if (!User::isLoggedIn()) {
            header("Location: /user/login");
        } else {

            $overlayList = Gallery::getOverlayList();

            require_once(ROOT . "/views/gallery/camera.php");
        }
        return true;
    }
}