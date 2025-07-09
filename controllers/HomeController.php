<?php

class HomeController
{
    public function index() 
    {
        $title = 'PolyShop - Trang chủ';
        $view = 'home';
        require_once PATH_VIEW . 'main.php';
    }
}