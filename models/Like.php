<?php

class Like
{

    public static function add($userId, $postId)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `likes` (user_id, post_id) VALUES (:user_id, :post_id)';

        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $result->bindParam(':post_id', $postId, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function remove($userId, $postId)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `likes` WHERE user_id = :user_id AND post_id = :post_id';

        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $result->bindParam(':post_id', $postId, PDO::PARAM_INT);

        return ($result->execute());
    }

    public static function deleteAllLikesByPostId($postId)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `likes` WHERE post_id = :post_id';

        $result = $db->prepare($sql);
        $result->bindParam(':post_id', $postId, PDO::PARAM_INT);

        return ($result->execute());
    }

    public static function isPostAlreadyLiked($userId, $postId)
    {
        $dp = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM `likes` WHERE user_id = :user_id AND post_id = :post_id';

        $result = $dp->prepare($sql);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $result->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    public static function countLikesByPostId($postId)
    {
        $dp = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM `likes` WHERE post_id = :post_id';

        $result = $dp->prepare($sql);
        $result->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $result->execute();

        return ($result->fetchColumn());
    }

}