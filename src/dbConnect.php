<?php
// bdd
$connection = new PDO('mysql:host=' . $globalConfigs["database"]['host'] . ';port=' . $globalConfigs['database']["port"] . ";dbname=" . $globalConfigs['database']["db_name"] . '', $globalConfigs['database']['user'], $globalConfigs['database']['password']);


