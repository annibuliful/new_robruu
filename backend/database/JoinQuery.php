<?php

declare(strict_types=1);
require dirname(__DIR__).'/config/DB.php';
class JoinQuery extends DB_config
{
    // @var $pdo เป็น instance ของ PDO
  private $pdo;

  // @var $sql เก็บ SQL command ที่พร้อม execute
  private $sql;

  // @var $param เก็บ parameter เพื่อเอาไปทำ bind parameter
  private $param = array('');

  // @var $primarykey เก็บ primarykey ของหลายๆ tables
  private $primarykey = array();

  // @var $tables เก็บ tables ที่ต้องการ join
  private $tables = array();

  /**
  * เก็บ table ที่จะเอาไว้ join ลง $tables*/
    public function __construct(string $primarykey1,string $primarykey2)
    {
      $this->pdo = new PDO($this->dsn, $this->user, $this->password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $primarykey = array($primarykey1,$primarykey2);
      $this->tables = array_merge($this->tables,$primarykey);
    }

    /**
     * ฟังก์ชั่นในการ select data
     *
     * @param array $tables คือ tables และ columns [tables.columns]
     * @return $this
     */
    public function select(array $tables)
    {
        $sql = 'SELECT ';
        $tables_size = (int)count($tables);
        $tables_num = (int)count($tables) - 1;
        for ($i=0; $i < $tables_size ; $i++) {
          if ($i < $tables_num) {
            $sql .= "{$tables[$i]},";
          }else {
            $sql .= "{$tables[$i]} ";
          }
        }

        $this->sql = $sql;

        return $this;
    }

    /**
     * ฟังก์ชั่นกำหนดเงื่อนไข.
     *
     * @param string $sql       คำสั่ง SQL หลัก
     * @param array  $condition เงื่อนไขที่ต้องการ และตัวดำเนินการทางตรรกศาสตร์
     * @param array  $param คือ parameter สำหรับการทำ bind parameter
     *
     * @return $this
     */
    public function where(array $condition,array $param)
    {
        $sql = 'WHERE ';
        $condition_size = (int) count($condition);
        $condition_num = (int) count($condition) - 1;
        for ($i = 0; $i < $condition_size; ++$i) {
            if ($i < $condition_num) {
                $sql .= "{$condition[$i]} ";
            } else {
                $sql .= "{$condition[$i]} ";
            }
        }
        $this->sql = $this->sql.$sql;
        $this->param = array_merge($this->param,$param);
        return $this;
    }

    /**
    * ฟังก์ชั่นในเก็บค่า tables ลง array
    * @param string $primarykey1 คือ table พร้อมก
    * @param string $table2 คือ table ที่ 2
    * @return $this
    */
    public function inner(string $primarykey1,string $primarykey2)
    {
      $tables = $this->tables;
      $sql = "FROM {$tables[0]} INNER JOIN {$tables[1]} ON {$primarykey1} = {$primarykey2} ";
      $this->sql = $this->sql.$sql;
      return $this;

    }

    /**
    * ฟังก์ชั่น outer
    * @param string $primarykey1 คือ table พร้อมก
    * @param string $table2 คือ table ที่ 2
    * @return $this
    */
    public function outer(string $primarykey1,string $primarykey2)
    {
      $tables = $this->tables;
      $sql = "FROM {$tables[0]} FULL OUTER JOIN {$tables[1]} ON {$primarykey1} = {$primarykey2} ";
      $this->sql = $this->sql.$sql;
      return $this;

    }

    /**
    * ฟังก์ชั่น left join
    * @param string $primarykey1 คือ table พร้อมก
    * @param string $table2 คือ table ที่ 2
    * @return $this
    */
    public function left(string $primarykey1,string $primarykey2)
    {
      $tables = $this->tables;
      $sql = "FROM {$tables[0]} LEFT JOIN {$tables[1]} ON {$primarykey1} = {$primarykey2} ";
      $this->sql = $this->sql.$sql;
      return $this;

    }

    /**
    * ฟังก์ชั่น right join
    * @param string $primarykey1 คือ table พร้อมก
    * @param string $table2 คือ table ที่ 2
    * @return $this
    */
    public function right(string $primarykey1,string $primarykey2)
    {
      $tables = $this->tables;
      $sql = "FROM {$tables[0]} LEFT JOIN {$tables[1]} ON {$primarykey1} = {$primarykey2} ";
      $this->sql = $this->sql.$sql;
      return $this;

    }

      /**
       * ฟังก์ชั่น execute SQL command แล้วคืนค่าจาก DB.
       *
       * @return $this->sql
       */
      public function exec()
      {
          $sql = $this->pdo->prepare($this->sql);
          $param = $this->param;
          $param_size = (int) count($this->param);
          for ($i = 1; $i < $param_size; ++$i) {
              $sql->bindParam($i, $param[$i]);
          }
          $sql->execute();
          while ($fetch = $sql->fetch(PDO::FETCH_ASSOC)) {
              array_push($this->fetch, $fetch);
          }

          return $this;
      }
    /**
     * ฟังก์ชั่นสำหรับเก็บ parameter เพื่อเอาไปใช้ในการทำ bind parameter.
     *
     * @param array $param คือ parameter ที่เอาไปทำ bind parameter
     *
     * @return $this
     */
    public function param(array $param)
    {
        $this->param = array_merge($this->param, $param);

        return $this;
    }

    /**
     * ฟังก์ชั่นคืนค่า primarykey.
     *
     * @return $this->primarykey
     */
    public function getPrimarykey()
    {
        return $this->primarykey;
    }

    /**
     * ฟังก์ชั่นคืนค่าจาก sql.
     *
     * @return $this->sql
     */
    public function getSql()
    {
        return (string) $this->sql;
    }
}
