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
 $this->assertEquals($result, $sql->select($table,$columns));
 }
 public function select()
 {
 return [
 ['test',array(),'SELECT * FROM test'],
 ['test', array('test1','test2'),'SELECT test1,test2 FROM test']
 ];
 }
}
?>
