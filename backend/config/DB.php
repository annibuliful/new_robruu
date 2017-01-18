<?php

declare(strict_types=1);
class DB_config
{
    protected $dsn = 'mysql:dbname=test;host=127.0.0.1';
    protected $user = 'root';
    protected $password = '@PeNtesterMYSQL';

    public function __construct()
    {
    }

    /*
    * ฟังก์ชั่นเก็บค่าในการใช้ PDO
    * @return array ค่าสำหรับ PDO
    */
    public function get_pdo()
    {
        return (array) array($this->dsn, $this->user, $this->password);
    }
}
