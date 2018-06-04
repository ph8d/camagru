<?php

include_once ROOT . '/models/User.php';
include_once ROOT . '/models/Settings.php';
include_once ROOT . '/models/Post.php';
include_once ROOT . '/models/Comment.php';

class SettingsController
{

    public function actionAccount()
    {
        if ($userId = User::isLoggedIn()) {

            $user = User::getUserById($userId);

            $loginError = false;
            $emailError = false;

            $login = $user['login'];
            $email = $user['email'];

            if (isset($_POST['submit_login'])) {
                $login = htmlspecialchars($_POST['new_login'], ENT_HTML5);

                if (!User::checkLogin($login)) {
                    $loginError = "Invalid login, minimum length is 4 and max length is 20 symbols.";
                }

                if (User::isLoginExists($login)) {
                    $loginError = "This login is already in use";
                }

                if ($loginError === false) {
                    User::editLogin($user['id'], $login);
                    $user['login'] = $login;
                    User::auth($user);
                    Post::updateUserLoginForAllPosts($user['id'], $login);
                    Comment::updateUserLoginForAllComments($user['id'], $login);
                }
            }

            if (isset($_POST['submit_email'])) {
                $email = $_POST['new_email'];

                if (!User::checkEmail($email)) {
                    $emailError = "Invalid email";
                }

                if (User::isEmailExists($email)) {
                    $emailError = "This email is already in use";
                }

                if ($emailError === false) {
                    User::editEmail($user['id'], $email);
                }
            }

            require_once(ROOT . '/views/settings/account.php');
        } else {
            header("Location: /user/login");
        }

        return true;
    }

    public function actionNotifications()
    {
        if ($userId = User::isLoggedIn()) {
            $user = User::getUserById($userId);
            $userSettings = Settings::getUserSettingsListById($userId);

            require_once(ROOT . '/views/settings/notifications.php');
        } else {
            header("Location: /user/login");
        }

        return true;
    }

    public function actionPassword()
    {
        $currentPass = '';
        $newPass = '';
        $newPassRe = '';

        $error = false;

        if ($userId = User::isLoggedIn()) {
            $user = User::getUserById($userId);

            if (isset($_POST['submit'])) {
                $currentPass = $_POST['current_pass'];
                $newPass = $_POST['new_pass'];
                $newPassRe = $_POST['new_pass_re'];

                if (!User::checkPassword($newPass) || !User::checkPassword($newPassRe)) {
                    $error = "New password is invalid";
                }

                if ($newPass !== $newPassRe) {
                    $error = "Passwords does not match";
                }

                if (!User::checkUserData($user['login'], $currentPass)) {
                    $error = "Wrong current password";
                }

                if ($error === false) {
                    User::editPassword($user['id'], $newPass);
                    $currentPass = '';
                    $newPass = '';
                    $newPassRe = '';
                }
            }

            require_once(ROOT . '/views/settings/password.php');
        } else {
            header("Location: /user/login");
        }

        return true;
    }

    public function actionSave()
    {
        if ($userId = User::isLoggedIn()) {
            Settings::updateUserSettings($_POST);
            return true;
        }
        return false;
    }
}