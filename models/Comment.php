<?php

class Comment
{
    public static function addNew($postId, $authorId, $authorName, $commentText)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `comment` (post_id, author_id, author_name, text) VALUES (:post_id, :author_id, :author_name, :text)';

        $result = $db->prepare($sql);
        $result->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $result->bindParam(':author_id', $authorId, PDO::PARAM_INT);
        $result->bindParam(':author_name', $authorName, PDO::PARAM_STR);
        $result->bindParam(':text', $commentText, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function removeById($postId)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `comment` WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $postId, PDO::PARAM_INT);
        $result->execute();

        return ($result);
    }

    public static function removeAllCommentsByPostId($postId)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `comment` WHERE post_id = :post_id';

        $result = $db->prepare($sql);
        $result->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $result->execute();

        return ($result);
    }

    public static function getCommentListByPostId($postId)
    {
        $db = Db::getConnection();

        $commentList = array();

        $result = $db->query("SELECT * FROM `comment` WHERE `post_id`=" . $postId . " ORDER BY `date` ASC");

        $i = 0;
        while ($row = $result->fetch()) {
            $commentList[$i]['id'] = $row['id'];
            $commentList[$i]['post_id'] = $row['post_id'];
            $commentList[$i]['author_id'] = $row['author_id'];
            $commentList[$i]['author_name'] = $row['author_name'];
            $commentList[$i]['text'] = $row['text'];
            $commentList[$i]['date'] = $row['date'];
            $i++;
        }

        return ($commentList);
    }

    public static function updateUserLoginForAllComments($userId, $newLogin)
    {
        $db = Db::getConnection();

        $sql = "UPDATE comment SET author_name = :new_name WHERE author_id = :user_id";

        $result = $db->prepare($sql);
        $result->bindParam(':new_name', $newLogin, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return ($result->execute());
    }
}