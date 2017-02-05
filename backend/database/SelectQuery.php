<?php

class SelectQuery
{
    // @var $pdo เก็บค่า PDO
  private $pdo;

  // @var $select เก็บค่า SQL command จาก select()
  private $select;

  // @var $where เก็บค่า Condition จาก where()
  private $where;

  // @var $orderby เก็บค่าการเรียงจากน้อยไปมากหรือมากไปน้อย จาก orderby()
  private $orderby;

  // @var $param เก็บค่าสำหรับ bind parameter
  private $param = array();

  // @var $sql เก็บค่า SQL command ที่พร้อมจะ execute
  private $sql;

  // @var $data เก็บค่า fetch จาก SQL command
  public $fetch = array();

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

  /**
   * ฟังก์ชั่นสำหรับดึงข้อมูล
   *
   * @param string $table ชื่อ table ที่ต้องการ
   * @param array $columns ชื่อ columns ที่ต้องการ
   *
   * @return string $sql ใช้สำหรับ test แต่ตอน deploy ต้องเอาออก
   */
  public function select(string $table, array $columns = null)
  {
      $sql = 'SELECT ';
      if ($columns != null) {
          $columns_num = (int) count($columns) - 1;
          for ($i = 0; $i <= $columns_num; ++$i) {
              if ($i < $columns_num) {
                  $sql .= "{$table}.{$columns[$i]},";
              } else {
                  $sql .= "{$table}.{$columns[$i]} ";
              }
          }
          $sql .= "FROM {$table} ";
      } elseif ($columns == null) {
          $sql .= "{$table}.* FROM {$table} ";
      }

      $this->select = $sql;
      $this->sql = $sql;

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
     * ฟังก์ชั่นกำหนดเงื่อนไข.
     *
     * @param string $sql       คำสั่ง SQL หลัก
     * @param array  $condition เงื่อนไขที่ต้องการ และตัวดำเนินการทางตรรกศาสตร์
     * @param array  $param     คือตัวที่ใช้คู่กับ condition
     *
     * @return $this
     */
    public function where(array $condition = null)
    {
        $sql = 'WHERE ';
        $condition_num = (int) count($condition) - 1;
        for ($i = 0; $i <= $condition_num; ++$i) {
            if ($i < $condition_num) {
                $sql .= "{$condition[$i][0]} {$condition[$i][1]} ";
            } else {
                $sql .= "{$condition[$i][0]} {$condition[$i][1]} ";
            }
        }
        $this->where = $sql;
        $this->sql = $this->sql.$sql;

        return $this;
    }

  /**
   * ฟังก์ชั่นการเรียงจากน้อยไปมากหรือมากไปน้อย.
   *
   * @param array $columns ชื่อ columns ที่ต้องการ
   * @param array $poperties คือ poperties ที่ต้องการ [ASC,DESC]
   *
   * @return $this
   */
  public function orderby(array $columns, array $poperties)
  {
      $sql = 'ORDER BY ';
      $columns_num = (int) count($columns) - 1;
      for ($i = 0; $i <= $columns_num; ++$i) {
          if ($i < $columns_num) {
              $sql .= "{$columns[$i]} {$poperties[$i]},";
          } else {
              $sql .= "{$columns[$i]} {$poperties[$i]}";
          }
      }
      $this->orderby = $sql;
      $this->sql = $this->sql.$sql;

      return $this;
  }

  /**
   * ฟังก์ชั่นสำหรับจำกัดจำนวน record.
   *
   * @param int $num จำนวนที่ต้องการ
   * @param int $begin เริ่มตรงไหน (เริ่มที่ 0)
   * @param int $end จบตรงไหน
   *
   * @return $this
   */
  public function limit(int $num = null, int $begin = null, int $end = null)
  {
      $sql = 'LIMIT ';
      if ($begin != null && $end != null) {
          $sql .= "{$begin},{$end}";
      } elseif ($begin == null && $end == null) {
          $sql .= "{$num}";
      }
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
      for ($i = 0; $i < $param_size; ++$i) {
          $sql->bindParam($i, $param[$i]);
      }
      $sql->execute();
      while ($fetch = $sql->fetch(PDO::FETCH_ASSOC)) {
          array_push($this->fetch, $fetch);
      }

      return $this;
  }
  /**
   * ฟังก์ชั่นคืนค่าจาก select.
   *
   * @return $this->select
   */
  public function getSelect()
  {
      return (string) $this->select;
  }

  /**
   * ฟังก์ชั่นคืนค่าจาก where.
   *
   * @return $this->where
   */
  public function getWhere()
  {
      return (string) $this->where;
  }

  /**
   * ฟังก์ชั่นคืนค่าจาก param.
   *
   * @return $this->param
   */
  public function getParam()
  {
      return (array) $this->param;
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

  /**
   * ฟังก์ชั่นคืนค่าจากการ execute.
   *
   * @return $this->fetch
   */
  public function getFetch()
  {
      return (array) $this->fetch;
  }
}
