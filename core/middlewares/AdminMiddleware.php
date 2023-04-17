<?php

namespace app\core\middlewares;

use app\core\Application;

class AdminMiddleware extends BaseMiddleware
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
        if (isset(Application::$app->user) && Application::$app->user->getUserType() === 'employee') {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                Application::$app->response->redirect('/applications');
            }
        }
    }
}