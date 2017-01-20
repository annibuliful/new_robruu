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

 /**
 * @dataProvider where
 */
 public function testwhere($Condition,$param,$result)
 {
   $sql = new SelectQuery();
   $this->assertEquals($result,$sql->where($Condition,$param));
 }
 public function select()
 {
 return [
 ['test',array(),'SELECT * FROM test'],
 ['test', array('test1','test2'),'SELECT test1,test2 FROM test'],
 ['test',array('test1','test2','test3','test4'),'SELECT test1,test2,test3,test4 FROM test']
 ];
 }
 public function where()
 {
   return  [
   [array('test1 = ','test2 >','test3 >','test4 <'),array(),'WHERE test1 = ? ,test2 > ? ,test3 > ? ,test < ? '],
   [array('test2 =','test3 <'),array('test'),false]];
 }
}
?>
