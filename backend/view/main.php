<?php

include dirname(__DIR__).'\controller\authen.php';
class html
{
    public $authen;
    public function __construct()
    {
        $this->authen = new authen_controller();
    }
    public function navbar()
    {
      
    }
}
?>
