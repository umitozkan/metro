<?php

class Controller
{
    public function view($name, $data = [])
    {
//        extract($data);
        require $_SERVER['DOCUMENT_ROOT'] . '/pages/' . strtolower($name) . '.php';
    }
}