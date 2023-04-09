<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\models\User;

class AuthController extends Controller
{
    public function login($request)
    {
        $this->setLayout('auth');
        if ($request->isGet()) {
            return $this->render('auth/login');
        }

        $body = $request->getBody();
    }

    public function register($request)
    {
        $this->setLayout('auth');
        $user = new User();

        if ($request->isPost()) {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->save())
            {
                Application::$app->session->setFlash('success', 'User registered successfully');
                Application::$app->response->redirect('/');
                exit;
            }

            return $this->render('auth/register', [
                'model' => $user
            ]);
        }

        return $this->render('auth/register', [
            'model' => $user
        ]);
    }
}