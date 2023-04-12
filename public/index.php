<?php

use app\controllers\ApplicationsController;
use app\controllers\AuthController;
use app\controllers\SiteController;
use app\controllers\UserController;
use app\core\Application;
use app\models\User;
use Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'userClass' => User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);

/* User routes */
$app->router->get('/users', [UserController::class, 'index']);
$app->router->post('/users/new', [UserController::class, 'store']);
$app->router->get('/users/new', [AuthController::class, 'register']);
$app->router->get('/users/{id:\d+}/edit', [UserController::class, 'edit']);
$app->router->post('/users/{id:\d+}/delete', [UserController::class, 'delete']);

/* Application routes */
$app->router->get('/applications', [ApplicationsController::class, 'index']);

$app->run();