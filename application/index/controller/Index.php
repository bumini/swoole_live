<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        echo 'hello thinkphp5.1';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
