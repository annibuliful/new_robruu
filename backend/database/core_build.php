<?php
declare(strict_types=1);
require dirname(__DIR__).'\config\DB.php';
require dirname(__DIR__).'\database\SelectQuery.php';
class core_build extends DB_config
{
  private $pdo;
  private $select;
  function __construct()
  {
    $this->pdo = new PDO($this->dsn,$this->user,$this->password);
    $this->select = new SelectQuery();
  }
}

 ?>
