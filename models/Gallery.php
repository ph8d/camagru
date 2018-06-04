<?php

class Gallery
{

    const POSTS_PER_PAGE = 6;

    public static function getGalleryList($page)
    {
        $db = Db::getConnection();

        $galleryList = array();

        $page = intval($page);
        $offset = ($page - 1) * self::POSTS_PER_PAGE;

        $result = $db->query("SELECT * FROM `post` ORDER BY `date` DESC LIMIT " . self::POSTS_PER_PAGE . " OFFSET " . $offset);

        $i = 0;
        while ($row = $result->fetch()) {
            $galleryList[$i]['id'] = $row['id'];
            $galleryList[$i]['author_id'] = $row['author_id'];
            $galleryList[$i]['author_name'] = $row['author_name'];
            $galleryList[$i]['date'] = $row['date'];
            $galleryList[$i]['likes'] = $row['likes'];
            $galleryList[$i]['img'] = $row['img'];
            $galleryList[$i]['class_name'] = "like unliked";
            $i++;
        }

        return ($galleryList);
    }

    public static function getOverlayList()
    {
        $db = Db::getConnection();

        $overlayList = array();


        $result = $db->query("SELECT * FROM `overlays`");

        $i = 0;
        while ($row = $result->fetch()) {
            $overlayList[$i]['id'] = $row['id'];
            $overlayList[$i]['name'] = $row['name'];
            $overlayList[$i]['path'] = $row['path'];
            $i++;
        }

        return ($overlayList);
    }


    public static function getGalleryItemById($id)
    {
        $id = intval($id);

        if ($id) {
            $db = Db::getConnection();

            $result = $db->query('SELECT * FROM post WHERE id='.$id);

            $result->setFetchMode(PDO::FETCH_ASSOC);
            $galleryItem = $result->fetch();

            return ($galleryItem);
        }

        return false;
    }

    public static function getGalleryListByUserId($userId, $page)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM `post` WHERE author_id = :userId ORDER BY `date` DESC LIMIT :postsLimit OFFSET :offset';

        $page = intval($page);
        $postsLimit = self::POSTS_PER_PAGE;
        $offset = ($page - 1) * $postsLimit;

        $result = $db->prepare($sql);
        $result->bindParam(':userId', $userId, PDO::PARAM_INT);
        $result->bindParam(':postsLimit', $postsLimit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);
        $result->execute();

        $galleryList = array();

        $i = 0;
        while ($row = $result->fetch()) {
            $galleryList[$i]['id'] = $row['id'];
            $galleryList[$i]['author_id'] = $row['author_id'];
            $galleryList[$i]['author_name'] = $row['author_name'];
            $galleryList[$i]['date'] = $row['date'];
            $galleryList[$i]['likes'] = $row['likes'];
            $galleryList[$i]['img'] = $row['img'];
            $galleryList[$i]['class_name'] = "like unliked";
            $i++;
        }

        return ($galleryList);
    }

    public static function getTotalPages()
    {
        $db = Db::getConnection();

        $sql = "SELECT COUNT(id) FROM post";

        $result = $db->prepare($sql);
        $result->execute();

        $row = $result->fetch();
        $totalRecords = $row['0'];
        $totalRecords = intval($totalRecords);

        return ceil($totalRecords / self::POSTS_PER_PAGE);
    }

    public static function getTotalPagesByUserId($userId)
    {
        $db = Db::getConnection();

        $sql = "SELECT COUNT(id) FROM post WHERE author_id = :user_id";

        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $result->execute();

        $row = $result->fetch();
        $totalRecords = $row['0'];
        $totalRecords = intval($totalRecords);

        return ceil($totalRecords / self::POSTS_PER_PAGE);
    }

}