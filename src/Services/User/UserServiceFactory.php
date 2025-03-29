<?php

declare(strict_types=1);

namespace App\Services\User;

use GuzzleHttp\Client;

class UserServiceFactory
{
    public function __construct(private readonly string $userUrl)
    {
    }

    public function create(): UserService
    {
        $client = new Client([
            'base_uri' => $this->userUrl,
            'timeout' => 5,
        ]);

        return new UserService($client);
    }
}
