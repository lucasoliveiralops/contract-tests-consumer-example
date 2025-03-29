<?php

declare(strict_types=1);

namespace App\Tests\Cases\Contract;

use App\Enum\Gender;
use App\Services\User\UserService;
use GuzzleHttp\Client;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class UserServiceTest extends TestCase
{
    private ConsumerRequest $request;

    private ProviderResponse $response;

    private Matcher $matcher;

    private MockServerEnvConfig $config;

    private UserService $service;

    protected function setUp(): void
    {
        $this->request = new ConsumerRequest();
        $this->response = new ProviderResponse();
        $this->matcher = new Matcher();
        $this->config = new MockServerEnvConfig();

        $this->config->setProvider('ms-user');

        $client = new Client([
            'base_uri' => $this->config->getBaseUri(),
            'timeout' => 5,
        ]);

        $this->service = new UserService($client);
    }

    public function testAuthorize(): void
    {
        $this->request->setMethod('GET')
            ->setPath('/users')
            ->addQueryParameter('age', 14)
            ->addQueryParameter('gender', 'M');

        $this->response->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody(
                $this->matcher->eachLike(
                    [
                        'id' => $this->matcher->integer($id = rand()),
                        'name' => $this->matcher->string('Name'),
                        'age' => $this->matcher->integer(14),
                        'gender' => $this->matcher->regex('M', '^[MWO]$'),
                    ],
                ),
            );

        $builder = new InteractionBuilder($this->config);

        $builder->given('A GET request to /user with filters for Age and Gender.')
            ->uponReceiving('One user matching your age (14) and gender (Male) was found.')
            ->with($this->request)
            ->willRespondWith($this->response);

        $users = $this->service->getByFilters(14, Gender::Man);

        $this->assertCount(1, $users);

        $user = $users[0];

        $this->assertEquals($id, $user->id);
        $this->assertEquals('Name', $user->name);
        $this->assertEquals(14, $user->age);
        $this->assertEquals(Gender::Man, $user->gender);

        $this->assertTrue($builder->verify(), 'We expect the pacts to validate');
    }

    public function testAuthorizeWithEmptyResponse(): void
    {
        $this->request->setMethod('GET')
            ->setPath('/users')
            ->addQueryParameter('age', 60)
            ->addQueryParameter('gender', 'W');

        $this->response->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody([]);

        $builder = new InteractionBuilder($this->config);

        $builder->given('A GET request to /user with filters for Age and Gender but empty.')
            ->uponReceiving('No results found')
            ->with($this->request)
            ->willRespondWith($this->response);

        $users = $this->service->getByFilters(60, Gender::Woman);

        $this->assertCount(0, $users);
        $this->assertTrue($builder->verify(), 'We expect the pacts to validate');
    }
}
