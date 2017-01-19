<?php

declare(strict_types=1);
class SelectQuery
{
    public function __construct()
    {
    }

  /*
  * ฟังก์ชั่นข้อมูล
  * @param string $table ชื่อ table ที่ต้องการ
  * @param array $columns ชื่อ columns ที่ต้องการ
  * @return string $sql
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

      return (string) $sql;
  }
}
