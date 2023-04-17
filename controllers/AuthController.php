<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\middlewares\AdminMiddleware;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['register']));
        $this->registerMiddleware(new AdminMiddleware(['store','register']));
    }

    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        $this->setLayout('auth');

        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());

            if ($loginForm->validate($request->getBody()) && $loginForm->login()) {
                $redirectUrl = Application::$app->getLoginRedirect();

                $response->redirect($redirectUrl);
                return;
            }
        }

        return $this->render('auth/login', [
            'model' => $loginForm
        ]);
    }

    public function register(Request $request)
    {
        $user = new User();

        return $this->render('users/add', [
            'model' => $user
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/login');
    }
}