<?php

include_once ROOT . '/models/Settings.php';
include_once(ROOT.'/components/guidv4.php');

class User
{
    public static function getUserById($id)
    {
        $id = intval($id);

        if ($id)
        {
            $db = Db::getConnection();
            $sql = 'SELECT * FROM `user` WHERE id = :id';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            return $result->fetch();
        }
        return false;
    }

    public static function getUserByEmail($email)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `user` WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

    public static function getUserByPostId($postId)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `post` WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $postId, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $row = $result->fetch();

        return User::getUserById($row['author_id']);
    }

    public static function getConfirmationHashByUserId($userId)
    {
        $db = Db::getConnection();
        $sql = 'SELECT confirmation_hash FROM `user` WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $userId, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetchColumn();
    }

    public static function register($login, $email, $password, $confirmationHash)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `user` (login, email, password, confirmation_hash) VALUES (:login, :email, :password, :confirmation_hash)';

        $password = hash("whirlpool", $password);

        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':confirmation_hash', $confirmationHash, PDO::PARAM_STR);


        if ($result->execute()) {
            $result = $db->query("SELECT LAST_INSERT_ID();");
            $row = $result->fetch();
            return $row['0'];
        }

        return false;
    }

    public static function sendConfirmationEmail($newUserId, $login, $userEmail, $confirmationHash)
    {
        $encoding  = "utf-8";

        $emailSubject = "Sign-up | Verification ";
        $subjectPreferences = array(
            "input-charset" => $encoding,
            "output-charset" => $encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );


        $message = '
<html>
    <head>
    </head>
    <body>
        <div style="text-align: center;font-family: \'Lato\', \'appleLogo\', sans-serif">
            <h1>Hey '.$login.', thanks for signing up!</h1>
            <p>Your camagru account has been created, you can confirm it by clicking the url below.</p>
            <a href="http://localhost:8101/user/confirm/'.$newUserId.'/'.$confirmationHash.'">Confirm my account</a>
        </div>
    </body>
</html>
';

        $emailHeader = "Content-type: text/html; charset=".$encoding." \r\n";
        $emailHeader .= "From: Camagru <no-reply@camagru.com> \r\n";
        $emailHeader .= "MIME-Version: 1.0 \r\n";
        $emailHeader .= "Content-Transfer-Encoding: 8bit \r\n";
        $emailHeader .= "Date: ".date("r (T)")." \r\n";
        $emailHeader .= iconv_mime_encode("Subject", $emailSubject, $subjectPreferences);

        return mail($userEmail, $emailSubject, $message, $emailHeader);
    }

    public static function sendEmailNotification($postAuthor, $postId)
    {
        if (!User::isNotificationsEnabled($postAuthor['id'])) {
            return false;
        }

        $encoding  = "utf-8";

        $emailSubject = "New comment on your post!";
        $subjectPreferences = array(
            "input-charset" => $encoding,
            "output-charset" => $encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );


        $message = '
<html>
    <head>
    </head>
    <body>
        <div style="text-align: center;font-family: \'Lato\', \'appleLogo\', sans-serif">
            <h1>Hey '.$postAuthor['login'].', there is a new comment on your post!</h1>
            <p>You can see it by clicking the url below.</p>
            <a href="http://localhost:8101/gallery/post/'.$postId.'">View my post</a>
        </div>
    </body>
</html>
';

        $emailHeader = "Content-type: text/html; charset=".$encoding." \r\n";
        $emailHeader .= "From: Camagru <no-reply@camagru.com> \r\n";
        $emailHeader .= "MIME-Version: 1.0 \r\n";
        $emailHeader .= "Content-Transfer-Encoding: 8bit \r\n";
        $emailHeader .= "Date: ".date("r (T)")." \r\n";
        $emailHeader .= iconv_mime_encode("Subject", $emailSubject, $subjectPreferences);

        return mail($postAuthor['email'], $emailSubject, $message, $emailHeader);
    }

    public static function sendRecoveryEmail($guid, $email)
    {
        $encoding  = "utf-8";

        $emailSubject = "Recovery";
        $subjectPreferences = array(
            "input-charset" => $encoding,
            "output-charset" => $encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );


        $message = '
<html>
    <head>
    </head>
    <body>
        <div style="text-align: center;font-family: \'Lato\', \'appleLogo\', sans-serif">
            <h1>Account recovery</h1>
            <p>We received an account recovery request. To recover your camagru account click the url below.</p>
            <a href="http://localhost:8101/user/reset/'.$guid.'">Recover procedure</a>
        </div>
    </body>
</html>
';

        $emailHeader = "Content-type: text/html; charset=".$encoding." \r\n";
        $emailHeader .= "From: Camagru <no-reply@camagru.com> \r\n";
        $emailHeader .= "MIME-Version: 1.0 \r\n";
        $emailHeader .= "Content-Transfer-Encoding: 8bit \r\n";
        $emailHeader .= "Date: ".date("r (T)")." \r\n";
        $emailHeader .= iconv_mime_encode("Subject", $emailSubject, $subjectPreferences);

        return mail($email, $emailSubject, $message, $emailHeader);
    }

    public static function confirmAccount($userId)
    {
        $db = Db::getConnection();

        $sql = "UPDATE `user` SET is_confirmed = :is_confirmed WHERE id = :id";

        $is_confirmed = 1;

        $result = $db->prepare($sql);
        $result->bindParam(":id", $userId, PDO::PARAM_INT);
        $result->bindParam(":is_confirmed", $is_confirmed, PDO::PARAM_BOOL);

        return $result->execute();
    }

    public static function deleteUserById($userId)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `user` WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $userId, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function editLogin($id, $login)
    {
        $db = Db::getConnection();

        $sql = "UPDATE `user` SET login = :login WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':login', $login, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function editEmail($userId, $newEmail)
    {
        $db = Db::getConnection();

        $sql = "UPDATE `user` SET email = :email, is_confirmed = 0 WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $userId, PDO::PARAM_INT);
        $result->bindParam(':email', $newEmail, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function editPassword($userId, $newPass) {

        $db = Db::getConnection();

        $sql = "UPDATE `user` SET password = :new_pass WHERE id = :id";

        $newPass = hash("whirlpool", $newPass);

        $result = $db->prepare($sql);
        $result->bindParam(':id', $userId, PDO::PARAM_INT);
        $result->bindParam(':new_pass', $newPass, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function checkUserData($login, $password)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE login = :login AND password = :password';

        $password = hash("whirlpool", $password);

        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        if ($user = $result->fetch()) {
            return $user;
        }

        return false;
    }

    public static function auth($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_login'] = $user['login'];
    }

    public static function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_login']);
    }

    public static function checkLogin($login)
    {
        $len = strlen($login);
        if ($len < 4 || $len > 20) {
            return false;
        }
        if (!preg_match('/^[A-Za-z0-9]+(?:[_-][A-Za-z0-9]+)*$/', $login)) {
            return false;
        }
        return true;
    }

    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public static function checkPassword($password)
    {
        if (strlen($password) < 8) {
            return false;
        }
        return true;
    }

    public static function confirmPassword($password, $password_confirm)
    {
        if ($password !== $password_confirm) {
            return false;
        }
        return true;
    }

    public static function isConfirmedAccount($userId)
    {
        $dp = Db::getConnection();

        $sql = 'SELECT is_confirmed FROM `user` WHERE id = :id';

        $result = $dp->prepare($sql);
        $result->bindParam(':id', $userId, PDO::PARAM_INT);
        $result->execute();

        if ($result->fetchColumn() === "1") {
            return true;
        }
        return false;
    }

    public static function isLoginExists($login)
    {
        $dp = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE login = :login';

        $result = $dp->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    public static function isEmailExists($email)
    {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM user WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn())
            return true;
        return false;
    }

    public static function isLoggedIn()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_login'])) {
            return $_SESSION['user_id'];
        }
        return false;
    }

    public static function isNotificationsEnabled($userId)
    {
        $result = Settings::getPropertyValueByUserId($userId, "email_notifications");

        if ($result === "1") {
            return true;
        }
        return false;
    }

    public static function isValidPasswordChangeRequest($guid)
    {
        $db = Db::getConnection();

        $sql = 'SELECT user_id FROM `password_change_requests` WHERE id = :id';

        $guid = hash("whirlpool", $guid);

        $result = $db->prepare($sql);
        $result->bindParam(':id', $guid, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        return $row['user_id'];
    }

    public static function generatePasswordChangeRequest($guid, $userId)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `password_change_requests` (id, user_id) VALUES (:id, :user_id)';

        $guid = hash("whirlpool", $guid);

        $result = $db->prepare($sql);
        $result->bindParam(':id', $guid, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function removePasswordChangeRequest($guid)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `password_change_requests` WHERE id = :id';

        $guid = hash("whirlpool", $guid);

        $result = $db->prepare($sql);
        $result->bindParam(':id', $guid, PDO::PARAM_STR);

        return $result->execute();
    }

}