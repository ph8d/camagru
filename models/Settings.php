<?php

class Settings
{
    public static function getUserSettingsListById($userId)
    {
        $db = Db::getConnection();

        $settingsList = array();

        $result = $db->query("SELECT * FROM `settings` WHERE user_id=" . $userId);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $result->fetch()) {
            $settingsList[$i]['id'] = $row['id'];
            $settingsList[$i]['name'] = $row['name'];
            $settingsList[$i]['label'] = $row['label'];
            $settingsList[$i]['description'] = $row['description'];
            $settingsList[$i]['value'] = $row['value'];
            $i++;
        }

        return ($settingsList);
    }

    public static function getPropertyValueByUserId($userId, $propertyName)
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM `settings` WHERE name = :property_name AND user_id = :user_id";

        $result = $db->prepare($sql);
        $result->bindParam(":property_name", $propertyName, PDO::PARAM_STR);
        $result->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();

        return $row['value'];
    }

    public static function updateUserSettings($newSettings)
    {
        $db = Db::getConnection();

        $sql = "UPDATE `settings` SET value = :value WHERE id = :id";

        $result = $db->prepare($sql);
        foreach ($newSettings as $id => $value) {
            $result->bindParam(":id", $id, PDO::PARAM_INT);
            $result->bindParam(":value", $value, PDO::PARAM_STR);
            $result->execute();
        }
        return true;
    }

    public static function createSettingsForNewUser($userId)
    {
        $db = Db::getConnection();

        $sql = "INSERT INTO `settings` (name, label, description, value, user_id) ";
        $sql .= "SELECT name, label, description, value, :user_id AS user_id FROM `settings_default`";

        $result = $db->prepare($sql);
        $result->bindParam(":user_id", $userId, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function deleteSettingsByUserId($userId)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `settings` WHERE user_id = :user_id';

        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return $result->execute();
    }
}