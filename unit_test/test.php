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

 public function testwhere()
 {
   $sql = new SelectQuery();
   $this->assertEquals("WHERE test1 = ? ,test2 = ?",$sql->where(array('test1 =','test2 ='),array('xx','yy')));
 }
 public function select()
 {
 return [
 ['test',array(),'SELECT * FROM test'],
 ['test', array('test1','test2'),'SELECT test1,test2 FROM test'],
 ['test',array('test1','test2','test3','test4'),'SELECT test1,test2,test3,test4 FROM test']
 ];
 }
 /*public function where()
 {
   return  [
   [array('test1 =','test2 ='),array('xx','yy'),"WHERE test1 = ? ,test2 = ?"],
   [array('test1 =','test2 >','test3 >','test4 <'),array('x','y'),"WHERE test1 = ? ,test2 > ? ,test3 > ? ,test4 < ?"]
           ];
 }*/
}
?>
