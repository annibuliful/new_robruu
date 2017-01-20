<?php

declare(strict_types=1);
require dirname(__DIR__).'/util/array/array.php';
class SelectQuery
{
    // @var $array_tool เป็น instance สำหรับ class array_tool
  private $array_tool;

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

    public function __construct()
    {
        $this->array_tool = new array_tool();
    }

  /*
  * ฟังก์ชั่นข้อมูล
  * @param string $table ชื่อ table ที่ต้องการ
  * @param array $columns ชื่อ columns ที่ต้องการ
  * @return string $sql ใช้สำหรับ test แต่ตอน deploy ต้องเอาออก
  */
  public function select(string $table, array $columns = null)
  {
      $sql = 'SELECT ';
      if ($columns != null) {
          $columns_size = (int) count($columns);
          $columns_num = (int) count($columns) - 1;
          for ($i = 0; $i < $columns_size; ++$i) {
              if ($i < $columns_num) {
                  $sql .= "{$columns[$i]},";
              } else {
                  $sql .= "{$columns[$i]} ";
              }
          }
          $sql .= "FROM {$table}";
      } elseif ($columns == null) {
          $sql .= "* FROM {$table}";
      }

      $this->select = $sql;

      return $sql;
  }

  /*
  * ฟังก์ชั่นกำหนดเงื่อนไง
  * @param string $sql คำสั่ง SQL หลัก
  * @param array $condition เงื่อนไขที่ต้องการ
  * @param array $param คือตัวที่ใช้คู่กับ condition
  * @return boolean
  */
  public function where(array $condition, array $param)
  {
      $sql .= 'WHERE ';
      $condition_size = (int) count($condition);
      $condition_num = (int) count($condition) - 1;
          for ($i = 0; $i < $condition_size; ++$i) {
              if ($i < $condition_num) {
                  $sql .= "{$condition[$i]} ? ,";
              } else {
                  $sql .= "{$condition[$i]} ? ";
              }
          }
          $this->where = $sql;
          $this->param = array_merge($this->param, $param);

          return $sql;
  }
  /*
  * ฟังก์ชั่นการเรียงจากน้อยไปมากหรือมากไปน้อย
  * @param array $columns ชื่อ columns ที่ต้องการ
  * @param array $poperties คือ poperties ที่ต้องการ [ASC,DESC]
  */
  public function orderby(array $columns, array $poperties)
  {
      $sql = 'ORDER BY';
      $columns_size = (int) count($columns);
      $columns_num = (int) count($columns) - 1;
      for ($i = 0; $i < $columns_size; ++$i) {
        if ($i < $columns_num) {
          $sql .= "{$columns[$i]} {$poperties[$i]},";
        }else {
          $sql .= "{$columns[$i]} {$poperties[$i]}";
        }
      }
      $this->orderby = $sql;
      $this->param = array_merge($this->param, $param);
  }

  /*
  * ฟังก์ชั่นคืนค่าจาก select
  * @return $this->select
  */
  public function getSelect()
  {
      return (string) $this->select;
  }

  /*
  * ฟังก์ชั่นคืนค่าจาก where
  * @return $this->where
  */
  public function getWhere()
  {
      return (string) $this->where;
  }

  /*
  * ฟังก์ชั่นคืนค่าจาก param
  * @return $this->param
  */
  public function getParam()
  {
      return (string) $this->param;
  }

  /*
  * ฟังก์ชั่นคืนค่าจาก sql
  * @return $this->sql
  */
  public function getSql()
  {
      return (string) $this->sql;
  }
}
