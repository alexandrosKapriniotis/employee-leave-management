<?php

namespace app\tests\auth;

use app\core\Application;
use app\core\exception\ForbiddenException;
use app\models\User;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RedirectMiddleware;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

$config = [
    'userClass' => User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

$app = new Application(dirname(__DIR__), $config);
final class AuthenticationTest extends TestCase
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
    }

    /**
     * @throws GuzzleException
     */
    public function testGuestCannotSeeRegister()
    {
        $response = $this->client->request('GET','/users/new');
        $headersRedirect = $response->getHeader(RedirectMiddleware::HISTORY_HEADER);

        $this->assertContains($_ENV['APP_URL'].'login', $headersRedirect);
        $this->assertEquals(302, $response->getHeaderLine('X-Guzzle-Redirect-Status-History'));
    }

    public function testGuestsCannotRegister()
    {

        // TODO test that the auth middleware kicks in
    }
}