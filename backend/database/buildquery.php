<?php

include dirname(__DIR__).'\config\DB.php';
class buildquery extends DB_config
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = new PDO($this->dsn, $this->user, $this->password);
    }

  /* ฟังก์ชั่น select แล้ว fetch data จาก DB
  * @param string table คือ table ที่ต้องการ data จาก DB
  * @param array columns คือจำนวน column ที่ต้องการ
  * @param array where คือเงื่อนไขที่ต้องการ
  * @assert select('test');
  * @assert select('test',array('test1','test2'));
  * @assert select('test',array('test1','test2'),array(array('test1','=','yyy')));
  */
  public function select(string $table, array $columns = null, array $where = null)
  {
      $sql = 'SELECT ';
      if ($columns == null) {
          if ($where == null) {
              $sql .= "* FROM {$table};";
          } else {
              $where_size = (int) count($where);
              $where_num = (int) count($where) - 1;
              $sql .= "* FROM {$table} WHERE ";
              for ($i = 0; $i < $where_size; ++$i) {
                  if ($i < $where_num) {
                      $sql .= "{$where[$i][0]} {$where[$i][1]} {$where[$i][2]},";
                  } else {
                      $sql .= "{$where[$i][0]} {$where[$i][1]} {$where[$i][2]};";
                  }
              }
          }
      }elseif ($columns != null) {
        if ($where == null) {
          $columns_size = (int) count($columns);
          $columns_num = (int) count($columns) - 1 ;
          for ($i=0; $i < $columns_size ; $i++) {
            if ($i < $columns_num) {
              $sql .= "{$columns[$i]},";
            }else {
              $sql .= "{$columns[$i]} ";
            }
          }
          $sql .= "FROM {$table};";
        }else {
          $columns_size = (int) count($columns);
          $columns_size = (int) count($columns) - 1 ;
          $where_size = (int) count($where);
          $where_num = (int) count($where) - 1;
          for ($i=0; $i < $columns_size ; $i++) {
            if ($i < $columns_num) {
              $sql .= "{$columns[$i]},";
            }else {
              $sql .= "{$columns[$i]} ";
            }
          }
          $sql .= " FROM {$table} WHERE ";
          for ($i = 0; $i < $where_size; ++$i) {
              if ($i < $where_num) {
                  $sql .= "{$where[$i][0]} {$where[$i][1]} {$where[$i][2]},";
              } else {
                  $sql .= "{$where[$i][0]} {$where[$i][1]} {$where[$i][2]};";
              }
          }
        }
      }
      return (string) $sql;
  }
}
$s = new buildquery();
echo $s->select('test',array('test1','test2'));
