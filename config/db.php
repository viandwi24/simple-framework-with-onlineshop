<?php

/**
 * DATABASE
 * MySql / Mariadb      = mysql
 * MS SQL               = mssql
 * Sybase               = sybase
 * SQLite               = sqlite 
 * PostgreSQL           = pgsql
 */

 /** GENERAL INFO */
$db = [
    'driver'    => 'pgsql',
    'host'      => 'localhost',
    'port'      => '5432',
    'dbname'    => 'onlenshop',
    'username'  => 'viandwi24',
    'password'  => '63945'
];












/** query pdo to connect */
$query = $db['driver'] 
    . ":host=" . $db['host']
    . ";port=" . $db['port']
    . ";dbname=" . $db['dbname']
    . ";user=" . $db['username']
    . ";password=" . $db['password']
    . "";




/** return config */
return ['dbconfig' => $db, 'query' => $query];