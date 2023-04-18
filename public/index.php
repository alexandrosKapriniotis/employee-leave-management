<?php

use app\controllers\ApplicationsController;
use app\controllers\AuthController;
use app\controllers\SiteController;
use app\controllers\UserController;
use app\core\Application;
use app\models\User;
use Dotenv\Dotenv;
use Postmark\PostmarkClient;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'appUrl'    => $_ENV['APP_URL'],
    'userClass' => User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ],
    'email' => [
        'from'   => $_ENV['EMAIL_FROM']
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
$app->router->get('/users/{id:\d+}', [UserController::class, 'show']);
$app->router->get('/users/{id:\d+}/edit', [UserController::class, 'edit']);
$app->router->post('/users/delete', [UserController::class, 'delete']);
$app->router->post('/users/{id:\d+}/update', [UserController::class, 'update']);

/* Application routes */
$app->router->get('/applications', [ApplicationsController::class, 'index']);
$app->router->get('/applications/new', [ApplicationsController::class, 'add']);
$app->router->post('/applications/new', [ApplicationsController::class, 'store']);
$app->router->get('/applications/{id:\d+}/status/{status:approved}', [ApplicationsController::class, 'updateStatus']);
$app->router->get('/applications/{id:\d+}/status/{status:rejected}', [ApplicationsController::class, 'updateStatus']);

$app->run();