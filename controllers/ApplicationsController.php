<?php

namespace app\controllers;

use app\core\Application as coreApplication;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\middlewares\EmployeeMiddleware;
use app\core\Request;
use app\models\Application;
use app\models\User;

class ApplicationsController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());
        $this->registerMiddleware(new EmployeeMiddleware());
    }

    /**
     * @return array|false|string|string[]
     */
    public function index()
    {
        return $this->render('applications/index',[
            'applications' => coreApplication::$app->user->getMyApplications()
        ]);
    }

    public function add()
    {
        return $this->render('applications/add', [
            'model' => new Application()
        ]);
    }

    /**
     * @param Request $request
     * @return array|false|string|string[]|void
     */
    public function store(Request $request)
    {
        $application = new Application();
        $requestBody = $request->getBody();
        $requestBody['user_id'] = coreApplication::$app->user->id;

        if ($application->validate($requestBody) && $application = $application->save($requestBody))
        {
            User::notifyAdmins($application);
            coreApplication::$app->session->setFlash('success', 'Application submitted successfully');
            coreApplication::$app->response->redirect('/applications');
            return;
        }

        return $this->render('applications/add', [
            'model' => $application
        ]);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function updateStatus(Request $request)
    {
        Application::updateStatus($request->getRouteParam('id'), $request->getRouteParam('status'));
    }
}