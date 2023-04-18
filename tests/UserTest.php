<?php

use app\core\Application;
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
final class UserTest extends TestCase
{
    protected $client;

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

    public function test_user_validation()
    {
        $user = new User();
        $rand  = rand(1,100);
        $this->assertTrue($user->validate([
            'first_name' => 'Bon',
            'last_name'  => 'Jovi',
            'email'      => $rand.'test@test.com',
            'user_type'  => 'employee',
            'password'   => 'rootadmin',
            'confirmPassword' => 'rootadmin'
        ]));
        $user->validate([
            'first_name' => 'Bon',
            'last_name'  => 'Jovi',
            'email'      => $rand.'test@test.com',
            'user_type'  => 'employee',
            'password'   => 'rootadmin',
            'confirmPassword' => 'rootadmin'
        ]);

        $this->assertFalse($user->validate([
            'first_name' => '',
            'last_name'  => '',
            'email'      => '',
            'user_type'  => '',
            'password'   => '',
            'confirmPassword' => ''
        ]));
    }

    public function test_users_can_be_fetched()
    {
        $this->assertNotFalse(User::findAll());
        $this->assertGreaterThanOrEqual(2, User::findAll());
    }

    public function test_a_user_can_be_saved()
    {
        $user = new User();
        $arrayValues = [
            'first_name' => 'Bon',
            'last_name'  => 'Jovi',
            'email'      => 'test@test.com',
            'user_type'  => 'employee',
            'password'   => 'rootadmin',
            'confirmPassword' => 'rootadmin'
        ];

        $user = $user->save($arrayValues);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals( 'Bon', $user->first_name);
        $this->assertEquals( 'Jovi', $user->last_name);
        $this->assertEquals( 'test@test.com', $user->email);
        $this->assertEquals( 'employee', $user->getUserType());
    }

    public function test_a_user_can_be_deleted()
    {
        $user = new User();
        $arrayValues = [
            'first_name' => 'Bon',
            'last_name'  => 'Jovi',
            'email'      => 'test@test.com',
            'user_type'  => 'employee',
            'password'   => 'rootadmin',
            'confirmPassword' => 'rootadmin'
        ];

        $user = $user->save($arrayValues);

        $this->assertTrue(User::delete($user->id));
    }

    public function test_a_user_can_be_updated()
    {
        $user = new User();
        $arrayValues = [
            'first_name' => 'Bon',
            'last_name'  => 'Jovi',
            'email'      => 'test@test.com',
            'user_type'  => 'employee',
            'password'   => 'rootadmin',
            'confirmPassword' => 'rootadmin'
        ];
        $user = $user->save($arrayValues);

        $user->update(['id' => $user->id], ['first_name' => 'updatedName']);

        $this->assertEquals('updatedName', User::findById($user->id)->first_name);
    }

    public function tearDown()
    {
        Application::$app->db->pdo->rollBack();
    }
}