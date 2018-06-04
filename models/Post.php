<?php

class Post
{

    public static function create($author_id, $author_name, $img) {

        $db = Db::getConnection();

        $sql = 'INSERT INTO `post` (author_id, author_name, img) VALUES (:author_id, :author_name, :img)';

        $result = $db->prepare($sql);
        $result->bindParam(':author_id', $author_id, PDO::PARAM_INT);
        $result->bindParam(':author_name', $author_name, PDO::PARAM_STR);
        $result->bindParam(':img', $img, PDO::PARAM_STR);

        return $result->execute();

    }

    public static function delete($postId) {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `post` WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $postId, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function deleteImg($postId) {
        $db = Db::getConnection();

        $sql = 'SELECT img FROM `post` WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $postId, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        if (isset($row['img'])) {
            $img_path = ROOT . "/" . $row['img'];

            if (file_exists($img_path)) {
                unlink($img_path);
                return true;
            }
        }
        return false;
    }

    public static function convertB64Img($author_name, $img) {

        $parsedImg = explode(',', $img);

        $imgName = "tmp" . "_" . $author_name . uniqid() . ".png";
        $imgSrc = str_replace(' ', '+', $parsedImg['1']);
        $imgSrc = base64_decode($imgSrc);

        if (!file_exists('img/tmp')) {
            mkdir('img/tmp');
        }

        $imgFullPath = 'img/tmp/' . $imgName;

        $file = fopen($imgFullPath, "wr");
        fwrite($file, $imgSrc);
        fclose($file);

        return $imgFullPath;
    }

    public static function getSuperposedImg($userImgPath, $overlayImgPath)
    {
        list($overlayWidth, $overlayHeight) = getimagesize($overlayImgPath);
        list($userWidth, $userHeight) = getimagesize($userImgPath);

        $userImgInfo = getimagesize($userImgPath);
        $userImgType = str_replace("image/", "", $userImgInfo['mime']);

        $resultImg = imagecreatetruecolor($userWidth, $userHeight);
        imagesavealpha($resultImg, true);
        $transparentBg = imagecolorallocatealpha($resultImg, 0, 0, 0, 127);
        imagefill($resultImg, 0, 0, $transparentBg);

        if (preg_match('/(gif)|(png)|(jpeg)/', $userImgType)) {
            $userImg = call_user_func("imagecreatefrom".$userImgType, $userImgPath);
        }

        if (!isset($userImg) || $userImg === false) {
            unlink($userImgPath);
            return false;
        }

        $overlayImg = imagecreatefrompng($overlayImgPath);

        $overlayWidth *= 0.5;
        $overlayHeight *= 0.5;
        $overlayImg = imagescale($overlayImg, $overlayWidth, $overlayHeight);

        imagecopy($resultImg, $userImg, 0, 0, 0, 0, $userWidth, $userHeight);
        imagecopy($resultImg, $overlayImg, 0, 0, 0, 0, $overlayWidth, $overlayHeight);

        imagedestroy($userImg);
        imagedestroy($overlayImg);
        unlink($userImgPath);

        return $resultImg;
    }

    public static function saveSuperposedImg($resultImg, $authorLogin)
    {
        $resultImgName = $authorLogin . "_" . uniqid() . ".png";

        if (!file_exists('img/posts/' . $authorLogin)) {
            mkdir('img/posts/' . $authorLogin);
        }

        $resultImgPath = "img/posts/" . $authorLogin . "/" . $resultImgName;

        $result = imagepng($resultImg, $resultImgPath,0);
        imagedestroy($resultImg);

        return $resultImgPath;
    }

    public static function getOverlayImgById($overlayImgId)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM `overlays` WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $overlayImgId, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $overlay = $result->fetch();

        return $overlay;
    }

    public static function updateUserLoginForAllPosts($userId, $newLogin)
    {
        $db = Db::getConnection();

        $sql = "UPDATE post SET author_name = :new_login WHERE author_id = :user_id";

        $result = $db->prepare($sql);
        $result->bindParam(':new_login', $newLogin, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return ($result->execute());
    }

    public static function saveUploadedImg($author_name, $uploadedImgPath)
    {
        $imgInfo = getimagesize($uploadedImgPath);
        $imgType = str_replace("image/", "", $imgInfo['mime']);

        $destinationFileName = "tmp" . "_" . $author_name . uniqid() . $imgType;

        if (!file_exists('img/tmp')) {
            mkdir('img/tmp');
        }

        $destinationPath = 'img/tmp/' . $destinationFileName;
        move_uploaded_file($uploadedImgPath, $destinationPath);

        return $destinationPath;
    }

}