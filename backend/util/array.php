<?php

class array_tool
{
    public function __construct()
    {
    }
    public function To_Onedimen(array $array)
    {
        $result = array_reduce($array, 'array_merge', array());
        return (array)$result;
    }
}
