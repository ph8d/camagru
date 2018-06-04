<?php

include_once ROOT . '/models/User.php';

class UserController
{
    public function  actionRegister()
    {
        $login = '';
        $email = '';
        $password = '';
        $password_confirm = '';

        if (isset($_POST['submit']) && $_POST['submit'] === 'OK') {
            $login = trim($_POST['login']);
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $errors = false;

            if (!User::checkLogin($login)) {
                $errors[] = 'Invalid login! Allowed length 4-20 symbols, allowed symbols (a-z, A-Z, 0-9, -, _)';
            }

            if (!User::checkEmail($email)) {
                $errors[] = 'Email is incorrect';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Password is too short, minimum length is 8 symbols';
            }

            if (!User::confirmPassword($password, $password_confirm)) {
                $errors[] = 'Passwords does not match';
            }

            if (User::isLoginExists($login)) {
                $errors[] = "This login is already in use";
            }

            if (User::isEmailExists($email)) {
                $errors[] = "This email is already in use";
            }

            $confirmationHash = $login . rand(1000, 9999) . $email . uniqid();
            $confirmationHash = hash("whirlpool", $confirmationHash);

            if ($errors === false) {
                $newUserId = User::register($login, $email, $password, $confirmationHash);
                Settings::createSettingsForNewUser($newUserId);
                User::sendConfirmationEmail($newUserId, $login, $email, $confirmationHash);
                $result = true;
                header("Refresh:2; /user/login");
            }
        }

        require_once(ROOT . "/views/user/sign-up.php");

        return true;
    }

    public function actionConfirm($userId, $receivedHash)
    {
        if (isset($userId)) {

            if (User::isConfirmedAccount($userId)) {
                header("Location: /gallery");
            } else {
                $confirmationHash = User::getConfirmationHashByUserId($userId);

                if ($receivedHash === $confirmationHash) {
                    User::confirmAccount($userId);
                    echo "Account successfully confirmed!";
                } else {
                    echo "Error! Wrong confirmation link!";
                }
                header("Refresh:2; /user/login");
            }
        } else {
            header("Location: /gallery");
        }

        return true;
    }

    public function actionDelete()
    {
        $userId = User::isLoggedIn();
        if ($userId && isset($_POST['password'])) {
            User::logout();
            User::deleteUserById($userId);
            Settings::deleteSettingsByUserId($userId);
            return true;
        }

        return false;
    }

    public function actionRecovery()
    {
        $email = '';

        $error = false;

        if (isset($_POST['submit'])) {

            $email = $_POST['email'];

            if (!User::checkEmail($email)) {
                $error = "Invalid email address";
            }

            if (!User::isEmailExists($email)) {
                $error = "No account found with that email address";
            }

            if ($error === false) {
                $user = User::getUserByEmail($email);
                $guid = guidv4();
                User::generatePasswordChangeRequest($guid, $user['id']);
                User::sendRecoveryEmail($guid, $email);

                $result = true;
                header("Refresh:4; /");
            }
        }

        require_once(ROOT . "/views/user/recovery.php");

        return true;
    }

    public function actionReset($guid)
    {
        $password = '';
        $password_re = '';

        $error = false;

        if ($guid) {

            if ($userId = User::isValidPasswordChangeRequest($guid)) {

                if (isset($_POST['submit'])) {

                    $password = $_POST['password'];
                    $password_re = $_POST['password_re'];

                    if (!User::checkPassword($password) || !User::checkPassword($password_re)) {
                        $error = "New password is invalid";
                    }

                    if ($password !== $password_re) {
                        $error = "Passwords does not match";
                    }

                    if ($error === false) {
                        User::editPassword($userId, $password);
                        User::removePasswordChangeRequest($guid);
                        $password = '';
                        $password_re = '';

                        $result = true;
                        header("Refresh:4; /user/login");
                    }

                }

                require_once(ROOT . "/views/user/password-reset.php");

                return true;
            }

        }

        return false;
    }

    public function actionLogin()
    {
        $login = '';
        $password = '';

        if (isset($_POST['submit']) && $_POST['submit'] === 'OK') {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $errors = false;

            if (!User::checkLogin($login)) {
                $errors[] = 'Minimum login length is 4 symbols and max len is 20 symbols';
            }

            if (!User::checkPassword($password)) {
                $errors[] = 'Password is too short, minimum length is 8 symbols';
            }

            $user = User::checkUserData($login, $password);
            if ($user === false) {
                $errors[] = "Login or password is incorrect";
            } else if (!User::isConfirmedAccount($user['id'])) {
                $errors[] = "Your account is not confirmed yet, please go to your email and confirm your account.";
            }

            if ($errors === false) {
                User::auth($user);
                header("Location: /gallery/");
            }
        }

        require_once(ROOT . "/views/user/sign-in.php");

        return true;
    }

    public function actionLogout()
    {
        if (User::isLoggedIn()) {
            User::logout();
        }
        header("Location: /gallery");
        return true;
    }
}