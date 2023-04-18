<?php

use app\core\Application;
use app\models\LoginForm;
use app\models\User;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
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

final class ApplicationTest extends TestCase
{
    protected $client;
    public $employeeUser;
    public $adminUser;

    protected function setUp()
    {
        $this->client = new Client([
            'request.options' => array(
                'exceptions' => true,
            ),
            'http_errors' => true,
            'allow_redirects' => ['track_redirects' => true],
            'base_uri' => $_ENV['APP_URL']
        ]);
        Application::$app->db->pdo->beginTransaction();
        $employeeUser = new User();
        $arrayValues = [
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => 'test_user@test.com',
            'user_type'  => 'employee'
        ];
        $employeeUser->setPassword('rootadmin');
        $employeeUser = $employeeUser->save($arrayValues);
        $this->employeeUser = $employeeUser;

        $adminUser = new User();
        $arrayValues = [
            'first_name' => 'Admin',
            'last_name'  => 'Test',
            'email'      => 'admin_test_user@test.com',
            'user_type'  => 'admin'
        ];
        $adminUser->setPassword('rootadmin');
        $adminUser = $adminUser->save($arrayValues);

        $loginForm = new LoginForm();
        $formData  = [
            'email' => 'admin_test_user@test.com',
            'password' => "rootadmin"
        ];
        $loginForm->email = $formData['email'];
        $loginForm->password = $formData["password"];
        $loginForm->login();
    }

    public function test_application_validation()
    {
        $application = new \app\models\Application();

        $this->assertTrue($application->validate([
            'date_from' => '2023-03-12',
            'date_to'  => '2023-03-15',
            'reason'      => 'i need vacation'
        ]));

        $this->assertFalse($application->validate([
            'date_from' => '',
            'date_to'  => '',
            'reason'      => ''
        ]));
    }

    public function test_application_can_be_created()
    {
        $application = new \app\models\Application();
        $arrayValues = [
            'date_from' => '2023-10-02',
            'date_to'   => '2023-10-04',
            'reason'    => 'i need vacation',
            'user_id'   =>  $this->employeeUser->id
        ];

        $application = $application->save($arrayValues);

        $this->assertInstanceOf(\app\models\Application::class, $application);
        $this->assertEquals( '2023-10-02', $application->getDateFrom());
        $this->assertEquals( '2023-10-04', $application->getDateTo());
        $this->assertEquals( 'i need vacation', $application->getReason());
        $this->assertEquals( $this->employeeUser->id, $application->getUserId());
        $this->assertEquals('pending', $application->getStatus());
    }

    public function test_application_status_be_updated()
    {
        $application = new \app\models\Application();
        $arrayValues = [
            'date_from' => '2023-10-02',
            'date_to'   => '2023-10-04',
            'reason'    => 'i need vacation',
            'user_id'   =>  $this->employeeUser->id
        ];

        $application = $application->save($arrayValues);

        $this->assertEquals('pending', $application->getStatus());
        $application->update(['id' => $application->id], ['status' => 'approved']);
    }

    public function tearDown()
    {
        Application::$app->db->pdo->rollBack();
    }
}