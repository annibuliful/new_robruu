<?php

class InsertQuery
{
    // @var $values เอาไว้เก็บค่าสำหรับ values
  private $values = array('');

    // @var $sql เก็บ SQL command
  private $sql;

    public function __construct()
    {
        //$this->pdo = $pdo;
        //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

  /**
   * ฟังก์ชั่นสำหรับ insert .
   *
   * @param string $table คือ table ที่ต้องการจะ insert
   * @param array $columns คือ columns ที่จะ insert
   * @param array $values คือ values ที่จะเอาไปทำ bind parameter
   *
   * @return $this
   */
  public function insert(string $table, array $columns = null)
  {
      $sql = 'INSERT INTO ';
      if ($columns == null) {
          $sql .= "{$table} VALUES";
      } elseif ($columns != null) {
          echo '1';
          $columns_num = (int) count($columns) - 1;
          $sql .= "{$table}(";
          for ($i = 0; $i <= $columns_num; ++$i) {
              if ($i < $columns_num) {
                  $sql .= "{$columns[$i]},";
              } else {
                  $sql .= "{$columns[$i]})";
              }
          }
      }
      $this->sql = $sql;

      return $this;
  }

  /**
   * ฟังก์ชั่นสำหรับเก็บค่า values เพื่อทำ bind parameter.
   *
   * @param array $param
   *
   * @return $this
   */
  public function values(array $values)
  {
      $this->values = array_merge($this->values, $values);

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
      return $this;
  }

  /**
   * ฟังก์ชั่นอ่านค่า SQL command.
   *
   * @return $this->sql
   */
  public function getSQL()
  {
      return $this->sql;
  }

  /**
   * ฟังก์ชั่นอ่านค่า SQL command.
   *
   * @return $this->sql
   */
  public function getValues()
  {
      return $this->values;
  }
}
