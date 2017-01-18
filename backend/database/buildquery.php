<?php

include dirname(__DIR__).'\config\DB.php';
class buildquery extends DB_config
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = new PDO($this->dsn, $this->user, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

  /*
  * ฟังก์ชั่น select แล้ว fetch data จาก DB
  * @param string table คือ table ที่ต้องการ data จาก DB
  * @param array columns คือจำนวน column ที่ต้องการ
  * @param array where คือเงื่อนไขที่ต้องการ
  * @return json data ที่ได้จาก DB
  * @assert select('test');
  * @assert select('test',array('test1','test2'));
  * @assert select('test',array('test1','test2'),array(array('test1','=','yyy')));
  */
  public function select(string $table, array $columns = null, array $where = null)
  {
      $sql = 'SELECT ';
      $condition = array();
      if ($columns == null) {
          if ($where == null) {
              $sql .= "* FROM {$table};";
          } else {
              $where_size = (int) count($where);
              $where_num = (int) count($where) - 1;
              $sql .= "* FROM {$table} WHERE ";
              for ($i = 0; $i < $where_size; ++$i) {
                  if ($i < $where_num) {
                      $sql .= "{$where[$i][0]} {$where[$i][1]} :{$i},"; //$where[$i][2]
                  } else {
                      $sql .= "{$where[$i][0]} {$where[$i][1]} :{$i};";
                  }
              }
          }
      } elseif ($columns != null) {
          if ($where == null) {
              $columns_size = (int) count($columns);
              $columns_num = (int) count($columns) - 1;
              for ($i = 0; $i < $columns_size; ++$i) {
                  if ($i < $columns_num) {
                      $sql .= "{$columns[$i]},";
                  } elseif ($i == $columns_num) {
                      $sql .= "{$columns[$i]} ";
                  }
              }
              $sql .= "FROM {$table};";
          } else {

              $columns_size = (int) count($columns);
              $columns_size = (int) count($columns) - 1;
              $where_size = (int) count($where);
              $where_num = (int) count($where) - 1;
              for ($i = 0; $i <= $columns_size; ++$i) {
                  if ($i <= $columns_num) {
                      $sql .= "{$columns[$i]},";
                  } else {
                      $sql .= "{$columns[$i]} ";
                  }
              }
              $sql .= " FROM {$table} WHERE ";
              for ($i = 0; $i < $where_size; ++$i) {
                  if ($i < $where_num) {
                      $sql .= "{$where[$i][0]} {$where[$i][1]} :{$i},";
                  } else {
                      $sql .= "{$where[$i][0]} {$where[$i][1]} :{$i};";
                  }
              }
              for ($i=0; $i <$where_size ; $i++) {
                array_push($condition,$where[$i][2]);
              }
          }
      }
      return [$sql,$condition];
  }

  /*
  * ฟังก์ชั่นในการเพิ่มข้อมูลเข้า DB
  * @param string $table คือ table ที่เราต้องการจะเพิ่มข้อมูล
  * @param array $columns คือ columns ที่ต้องการจะเพิ่มข้อมูล
  * @param array $values คือค่าที่ต้องการเพิ่มลง
  * @return $sql
  * @assert insert('test','',array('xxx','yyy'));
  * @assert insert('test',array('test1','test2'),array('xxx','yyy'));
  */
  public function insert(string $table, array $columns = null, array $values)
  {
      $sql = '';
      if ($columns == null) {
          $sql = "INSERT INTO {$table} VALUES (";
          $values_size = (int) count($values);
          $values_num = (int) count($values) - 1;
          for ($i = 0; $i < $values_size; ++$i) {
              if ($i < $values_num) {
                  $sql .= ":{$i} ,";
              } elseif ($i == $values_num) {
                  $sql .= ":{$i} );";
              }
          }
          $pdo = $this->pdo->prepare($sql);
          for ($i = 0; $i < $values_size; ++$i) {
              $param = ':'.$i;
              $pdo->bindParam($param, $values[$i]);
          }
          $pdo->execute();
      } elseif ($columns != null) {
          $sql = "INSERT INTO {$table}(";
          $columns_size = (int) count($columns);
          $columns_num = (int) count($columns) - 1;
          for ($i = 0; $i < $columns_size; ++$i) {
              if ($i < $columns_num) {
                  $sql .= "{$columns[$i]},";
              } elseif ($i == $columns_num) {
                  $sql .= "{$columns[$i]}) VALUES (";
              }
          }
          $values_size = (int) count($columns);
          $values_num = (int) count($columns) - 1;
          for ($i = 0; $i < $values_size; ++$i) {
              if ($i < $values_size_num) {
                  $sql .= ":{$i},";
              } elseif ($i == $values_num) {
                  $sql .= ":{$i});";
              }
          }
          $pdo = $this->pdo->prepare($sql);
          for ($i = 0; $i < $columns_size; ++$i) {
              $param = ':'.$i;
              $pdo->bindParam($param, $values[$i]);
          }
          $pdo->execute();
      }
  }
  public function exec(array $return)
  {
    $data = array();
    $values_size = count($return[1]);
    $pdo = $this->pdo->prepare($return[0]);
    for ($i=0; $i <$values_size ; $i++) {
      $param = ':'.$i;
      $pdo->bindParam($param,$return[1][$i]);
    }
    $pdo->execute();
    while ($fetch = $pdo->fetch(PDO::FETCH_ASSOC)) {
      array_push($data,$fetch);
    }
    return json_encode($data);

  }
}
