<?php
use PHPUnit\Framework\TestCase;
class DataTest extends TestCase
{

 /**
 * @dataProvider select
 */
 public function testselect($table, $columns, $result)
 {
   $sql = new SelectQuery();
 $this->assertEquals($result, $sql->select($table,$columns)->getSql());
 }

 public function select()
 {
 return [
 ['test',array(),'SELECT * FROM test'],
 ['test', array('test1','test2'),'SELECT test1,test2 FROM test'],
 ['test',array('test1','test2','test3','test4'),'SELECT test1,test2,test3,test4 FROM test']
 ];
 }
}
?>
