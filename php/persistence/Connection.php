<?php

namespace Persistence;

use Mysqli;

class Connection
{
    private static $connection;

    protected static function GetConnection()
    {
        if(self::$connection == null)
        {
            $config = new Config();
            $config = $config->getDatabase();
            self::$connection = new Mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
            if(self::$connection->connect_errno)
                die('Failed to connect to MySQL: (' . self::$connection->connect_errno . ')' . self::$connection->connect_error);
            self::$connection->set_charset("utf8");
        }
        return self::$connection;
    }
}