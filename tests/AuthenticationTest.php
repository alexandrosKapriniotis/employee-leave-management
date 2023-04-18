<?php

use app\core\Application;
use app\models\LoginForm;
use app\models\User;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'appUrl'    => $_ENV['APP_URL'],
    'userClass' => User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ],
    'email' => [
        'from'   => $_ENV['EMAIL_FROM']
    ]
];
new Application(dirname(__DIR__), $config);

final class AuthenticationTest extends TestCase
{
    protected function setUp() {
        $this->client = new Client([
            'request.options' => array(
                'exceptions' => true,
            ),
            'http_errors' => true,
            'allow_redirects' => ['track_redirects' => true],
            'base_uri' => $_ENV['APP_URL']
        ]);
        Application::$app->db->pdo->beginTransaction();
    }

    public function test_a_user_can_login()
    {
        $user = new User();
        $arrayValues = [
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => 'test_user@test.com',
            'user_type'  => 'employee'
        ];
        $user->setPassword('rootadmin');
        $user->save($arrayValues);

        $loginForm = new LoginForm();
        $formData  = [
            'email' => 'test_user@test.com',
            'password' => "rootadmin"
        ];
        $loginForm->email = $formData['email'];
        $loginForm->password = $formData["password"];
        $login = $loginForm->login();

        $this->assertTrue($loginForm->validate($formData));
        $this->assertNotFalse($login);
        $this->assertEquals('test_user@test.com', Application::$app->user->email);
    }

    public function tearDown()
    {
        Application::$app->db->pdo->rollBack();
    }
}