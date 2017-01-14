<?php

declare(strict_types=1);
class DB_config
{
    protected $dsn = 'mysql:dbname=robruu_online;host=127.0.0.1';
    protected $user = 'root';
    protected $password = '@PeNtesterMYSQL';
    protected $store_path = 'C:\Users\Dell\Documents\GitHub\new_robruu\frontend\store';

    public function __construct()
    {
    }
    public function get_pdo()
    {
        return (array) array($this->dsn, $this->user, $this->password);
    }
    public function get_store_path()
    {
        return (string) $this->store_path;
    }
}
