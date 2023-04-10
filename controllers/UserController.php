<?php

namespace app\controllers;

use app\core\Controller;
use app\core\middlewares\AuthMiddleware;

class UserController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['users']));
    }

    public function index()
    {
        return $this->render('users/index');
    }
}