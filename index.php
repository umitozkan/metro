<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/libs/Controller.php';
require __DIR__ . '/libs/Router.php';
include "vendor/autoload.php";


use GuzzleHttp\Client;


Router::get('/', function () {

    $client = new Client();
    $controller = new Controller();

    if (!isset($_SESSION['token'])) {
        $controller->view('login');
        die();
    }

    try {
        $statusCode = $client->get('127.0.0.1:8080',
            ['headers' =>
                [
                    'Authorization' => "Bearer {$_SESSION['token']}"
                ]])->getStatusCode();

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
        $token = str_replace("\"", '', $response->getBody());

        $_SESSION['token'] = $token;

        header("Location: /");


    } catch (GuzzleHttp\Exception\ClientException $e) {
        $response = $e->getResponse();
        $body = $response->getBody();

        if (!isset($body->error)) {
            header("Location: /");
        } else {
            echo $body->error;
        }
    }


});

Router::get('/logout', function () {
    session_destroy();
    header('Location: /');
});

Router::get('/talep-yonetimi', function () {
    $controller = new Controller();
    $controller->view('talep_yonetimi');
});