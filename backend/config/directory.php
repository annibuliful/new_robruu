<?php

declare(strict_types=1);
class dir_config
{
    protected $store_path = 'C:\Users\Dell\Documents\GitHub\new_robruu\frontend\store';
    public function __construct()
    {
    }

    /*
    * @return ที่เก็บไฟล์จากการอัพโหลด
    */
    public function get_store_path()
    {
        return (string) $this->store_path;
    }
}
?>
