<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;

class SiteController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function home()
    {
        if (Application::$app->user->getUserType() === 'admin') {
            Application::$app->response->redirect('/users');
        } else {
            Application::$app->response->redirect('/applications');
        }
        exit;
    }
}