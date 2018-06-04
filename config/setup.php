#!/usr/bin/php
<?php

include("database.php");

$script_path = "camagru.sql";

$command = "~/Library/Containers/MAMP/mysql/bin/mysql -u{$DB_USER} -p{$DB_PASSWORD} "
    . "-h {$DB_HOST} < {$script_path}";

$output = shell_exec($command);

echo $output;

?>