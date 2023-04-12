<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\models\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['users']));
    }

    public function index()
    {
        return $this->render('users/index',[
            'users' => User::findAll()
        ]);
    }

    /**
     * @param Request $request
     * @return array|false|string|string[]|void
     */
    public function store(Request $request)
    {
        $user = new User();

        if (!$request->isPost()) {
            Application::$app->response->redirect('/');
        }

        $user->loadData($request->getBody());

        if ($user->validate() && $user->save())
        {
            Application::$app->session->setFlash('success', 'User registered successfully');
            Application::$app->response->redirect('/');
            exit;
        }

        return $this->render('users/add', [
            'model' => $user
        ]);
    }

    public function edit(Request $request) {
        $user = User::findOne(['id' => $request->getRouteParam('id')]);

        return $this->render('users/edit', [
            'model' => $user
        ]);
    }
}