<?php

namespace app\core;

class View
{
    public $title = '';

    public function renderView($view, $params = [])
    {
        $layoutName = Application::$app->layout;
        if (Application::$app->controller) {
            $layoutName = Application::$app->controller->layout;
        }

        $viewContent = $this->renderViewOnly($view, $params);

        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layoutName.php";
        $layoutContent = ob_get_clean();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function renderViewOnly(string $view, array $params = []): string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}