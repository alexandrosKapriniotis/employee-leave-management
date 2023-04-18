<?php

use app\core\Application;
use app\models\User;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RedirectMiddleware;
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

final class AuthorizationTest extends TestCase
{
    protected $client;
    protected $employeeUser;
    protected $adminUser;


    protected function setUp() {
        $this->client = new Client([
            'verify' => false,
            'request.options' => array(
                'exceptions' => true,
            ),
            'http_errors' => true,
            'allow_redirects' => ['track_redirects' => true],
            'base_uri' => $_ENV['APP_URL']
        ]);

        $this->employeeUser = new User('Ash', 'Ketchum','employee@test.com', 'employee');
        $this->adminUser = new User('Alex', 'Kap','admin@test.com', 'admin');
    }

    /**
     * @throws GuzzleException
     */
    public function test_guest_cannot_see_register()
    {
        $response = $this->client->request('GET','/users/new');
        $headersRedirect = $response->getHeader(RedirectMiddleware::HISTORY_HEADER);

        $this->assertContains($_ENV['APP_URL'].'/login', $headersRedirect);
        $this->assertEquals(302, $response->getHeaderLine('X-Guzzle-Redirect-Status-History'));
    }

    /**
     * @throws GuzzleException
     */
    public function test_guest_cannot_submit_registration()
    {

        $response = $this->client->request('POST','/users/new');
        $headersRedirect = $response->getHeader(RedirectMiddleware::HISTORY_HEADER);

        $this->assertContains($_ENV['APP_URL'].'/login', $headersRedirect);
        $this->assertEquals(302, $response->getHeaderLine('X-Guzzle-Redirect-Status-History'));
    }

    /**
     * @throws GuzzleException
     */
    public function test_employee_cannot_see_register()
    {
        Application::$app->user = $this->employeeUser;
        $response = $this->client->request('GET','/users/new');
        $headersRedirect = $response->getHeader(RedirectMiddleware::HISTORY_HEADER);

        $this->assertContains($_ENV['APP_URL'].'/login', $headersRedirect);
        $this->assertEquals(302, $response->getHeaderLine('X-Guzzle-Redirect-Status-History'));
    }

    /**
     * @throws GuzzleException
     */
    public function test_employee_cannot_submit_registration()
    {
        Application::$app->user = $this->employeeUser;

        $response = $this->client->request('POST','/users/new');
        $headersRedirect = $response->getHeader(RedirectMiddleware::HISTORY_HEADER);

        $this->assertContains($_ENV['APP_URL'].'/login', $headersRedirect);
        $this->assertEquals(302, $response->getHeaderLine('X-Guzzle-Redirect-Status-History'));
    }

    /**
     * @throws GuzzleException
     */
    public function test_admin_can_see_register()
    {
        Application::$app->user = $this->employeeUser;
        $response = $this->client->request('GET','/users/new');

        $this->assertEquals(200, $response->getStatusCode());
    }
}