<?php
namespace app\core;

use app\core\db\Database;
use app\core\db\DbModel;
use Postmark\PostmarkClient;

class Application
{
    public static $ROOT_DIR;
    public $layout = 'main';
    public $router;
    public $request;
    public $response;
    public static $app;
    public $controller = null;
    public $session;
    public $db;
    public $emailFrom;
    public $appUrl;
    public $userClass;
    public $user;
    public $view;

    /**
     * @param $rootPath
     * @param array $config
     */
    public function __construct($rootPath, array $config)
    {
        $this->user = null;
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->emailFrom   = $config['email']['from'];
        $this->appUrl      = $config['appUrl'];
        $this->view = new View();

        $userId = Application::$app->session->get('user');
        if ($userId) {
            $key = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$key => $userId]);
        }
    }

    /**
     * @return bool
     */
    public static function isGuest(): bool
    {
        return !self::$app->user;
    }

    /**
     * @return void
     */
    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            echo $this->router->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param DbModel $user
     * @return bool
     */
    public function login(DbModel $user): bool
    {
        $this->user = $user;
        $className = get_class($user);
        $primaryKey = $className::primaryKey();
        $value = $user->{$primaryKey};
        Application::$app->session->set('user', $value);

        return true;
    }

    /**
     * @return void
     */
    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    /**
     * @return mixed|string
     */
    public function getLoginRedirect()
    {
        $requestBody = $this->request->getBody();

        if (isset($requestBody['redirect'])) {
            $loginRedirect = $requestBody['redirect'];
        } else {
            $this->user->getUserType() === 'admin' ? $loginRedirect = '/users'
                : $loginRedirect = '/applications';
        }

        return $loginRedirect;
    }
}