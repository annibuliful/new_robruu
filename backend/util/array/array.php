<?php

declare(strict_types=1);
class array_tool
{
    public function __construct()
    {
    }
    public function To_Onedimen(array $array)
    {
        $result = array_reduce($array, 'array_merge', array());

        return (array) $result;
    }
    public function merge()
    {
        $return = array();
        $param = func_get_args();

        return (array) $return;
    }
}
