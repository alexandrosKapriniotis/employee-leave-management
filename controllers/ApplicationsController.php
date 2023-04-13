<?php

namespace app\controllers;

use app\core\Application as coreApplication;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\models\Application;
use app\models\User;

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

    public function add()
    {
        return $this->render('applications/add', [
            'model' => new Application()
        ]);
    }

    public function store(Request $request)
    {
        $application = new Application();
        $application->loadData($request->getBody());
        $application->setDateFrom($request->getBody()['date_from']);
        $application->setDateTo($request->getBody()['date_to']);
        $application->setReason($request->getBody()['reason']);
        $application->setUserId($request->getBody()['user_id']);

        if ($application->validate($request->getBody()) && $application->save($request->getBody()))
        {
            coreApplication::$app->session->setFlash('success', 'Application submitted successfully');
            coreApplication::$app->response->redirect('/applications');
            exit;
        }

        return $this->render('users/add', [
            'model' => $application
        ]);
    }
}