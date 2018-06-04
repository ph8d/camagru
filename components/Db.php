<?php

class Db
{

    public static function getConnection()
    {
        include(ROOT."/config/database.php");

        $dsn = $DB_DSN;
        $db = new PDO($dsn, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return ($db);
    }

}