<?php

namespace app\core\middlewares;

use app\core\Application;

class EmployeeMiddleware extends BaseMiddleware
{
    public $actions = [];

    /**
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (isset(Application::$app->user) && Application::$app->user->getUserType() === 'admin') {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                Application::$app->response->redirect('/users');
            }
        }
    }
}