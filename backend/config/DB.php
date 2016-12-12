<?php

class DB_config
{
  protected $dsn = 'mysql:dbname=robruu_online;host=127.0.0.1';
  protected $user = 'root';
  protected $password = '@PeNtesterMYSQL';

  function __construct()
  {
  }
  public function get_pdo()
  {
    return array($this->dsn,$this->user,$this->password);
  }
}


 ?>
