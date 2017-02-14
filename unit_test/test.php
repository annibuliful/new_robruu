<?php

use PHPUnit\Framework\TestCase;

class DataTest extends TestCase
{
    /**
  * @dataProvider select
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */
 public function testselect($table, $columns, $result)
 {
     $pdo = new PDO($GLOBALS['db_dsn'], $GLOBALS['db_username'], $GLOBALS['db_password']);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $sql = new SelectQuery($pdo);
     $this->assertEquals($result, $sql->select($table, $columns)->getSql());
 }

    public function select()
    {
        return [
 ['test', array(), 'SELECT test.* FROM test '],
 ['test', array('test1', 'test2'), 'SELECT test.test1,test.test2 FROM test '],
 ['test', array('test1', 'test2', 'test3', 'test4'), 'SELECT test.test1,test.test2,test.test3,test.test4 FROM test '],
 ];
    }
}
