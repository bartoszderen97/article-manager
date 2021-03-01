<?php

use Delight\Db\PdoDsn;

require __DIR__.'/../vendor/autoload.php';


class DbConnection
{
    private const DB_NAME = 'aurora';
    private const DB_HOST = 'localhost';
    private const DB_CHARSET = 'utf8mb4';
    private const DB_USERNAME = 'root';
    private const DB_PASSWORD = '';

    private $db;

    public function __construct()
    {
        $this->db = new PdoDsn('mysql:dbname='.self::DB_NAME
            .';host='.self::DB_HOST
            .';charset='.self::DB_CHARSET,
            self::DB_USERNAME,
            self::DB_PASSWORD);
    }

    public function getConnection(): PdoDsn
    {
        return $this->db;
    }
}