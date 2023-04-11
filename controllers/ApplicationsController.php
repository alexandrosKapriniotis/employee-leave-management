<?php

namespace app\controllers;

use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\models\Application;

class ApplicationsController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['applications']));
    }

    public function index()
    {
        return $this->render('applications/index',[
            'applications' => Application::findAll()
        ]);
    }
}