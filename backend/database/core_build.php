<?php
require dirname(__DIR__).'/database/SelectQuery.php';
require dirname(__DIR__).'/database/JoinQuery.php';
require dirname(__DIR__).'/config/DB.php';
class core_build extends DB_config
{
  // @var $pdo เก็บค่า PDO
  public $pdo;

  // @var $select instance สำหรับ SelectQuery class
  public $select;

  // @var $join instance สำหรับ JoinQuery class
  public $join;

  // @var $param เก็บ param เอาไว้ทำ bind parameter
  public $param;

  // @var $sql เก็บ SQL command เพื่อ execute
  public $sql;

  function __construct()
  {
    $this->pdo = new PDO($this->dsn, $this->user, $this->password);
  }

  /**
  * ฟังก์ชั่นสำหรับในการ select data แล้ว fetch
  * @return $instance
  */
  public function select(string $table, array $columns = null)
  {
    $query = new SelectQuery($this->pdo);
    $query->select($table,$columns);
    return $query;
  }
  /**
  * ฟังก์ชั่นในการทำ JOIN
  * @return */
  public function join(string $primarykey1,string $primarykey2)
  {
    $query = new JoinQuery($primarykey1,$primarykey2);
    return $query;
  }
}
$s = new core_build();
echo $s->select('test',array('sss','ttt'))->getSql();
 ?>
