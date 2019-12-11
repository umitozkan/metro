<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'libs/Controller.php';
require __DIR__ . '/libs/Router.php';
include "vendor/autoload.php";


Router::run('/', function () {
    $controller = new Controller();

    $controller->view('login');

});

//Router::run('/uyeler', 'uyeler@index');
//Route::run('/uyeler', 'uyeler@post', 'post');
//Route::run('/uye/{url}', 'uye@index');
//Route::run('/profil/sifre-degistir', 'profile/changepassword@index');