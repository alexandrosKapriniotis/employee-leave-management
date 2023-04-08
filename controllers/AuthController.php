<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Register;

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
        $errors = [];
        $this->setLayout('auth');
        $registerModel = new Register();

        if ($request->isPost()) {
            $registerModel->loadData($request->getBody());

            if ($registerModel->validate() && $registerModel->register())
            {
                return 'Success';
            }
            echo ' this right here';
            var_dump($registerModel->errors);
            return $this->render('auth/register', [
                'model' => $registerModel
            ]);
        }

        return $this->render('auth/register', [
            'model' => $registerModel
        ]);
    }
}