<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require __DIR__ . '/libs/Controller.php';
require __DIR__ . '/libs/Router.php';
include "vendor/autoload.php";


use GuzzleHttp\Client;


Router::get('/', function () {

    $client = new Client();
    $controller = new Controller();
    try {
        $client->get('127.0.0.1:8080');
    } catch (GuzzleHttp\Exception\ClientException $e) {
        $response = $e->getResponse();
        $statusCode = $response->getStatusCode();
    }

    if ($statusCode != 200) {
        $controller->view('login');
    } else {
        $controller->view('home');
    }


});

Router::post('/login', function () {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $client = new Client();
    try {
        $response = $client->post('127.0.0.1:8080/login', [
            'json' => [
                'email' => $username,
                'password' => $password
            ]
        ]);


       echo $response->getBody();
    } catch (GuzzleHttp\Exception\ClientException $e) {
        $response = $e->getResponse();
        $statusCode = $response->getStatusCode();

        echo $response->getBody();
    }



});




//Router::run('/uyeler', 'uyeler@index');
//Route::run('/uyeler', 'uyeler@post', 'post');
//Route::run('/uye/{url}', 'uye@index');
//Route::run('/profil/sifre-degistir', 'profile/changepassword@index');