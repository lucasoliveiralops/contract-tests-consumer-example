<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Entity\User;
use App\Enum\Gender;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class UserService
{
    public function __construct(private readonly Client $client)
    {
    }

    /**
     * @return ?User[]
     */
    public function getByFilters(int $age, Gender $gender): ?array
    {
        try {
            $response = $this->client->get('/users', [
                RequestOptions::QUERY => [
                    'gender' => $gender->value,
                    'age' => $age,
                ],
            ]);
        } catch (GuzzleException $e) {
            return null;
        }

        if ($response->getStatusCode() != 200) {
            return null;
        }

        $body = (string) $response->getBody();
        $body = json_decode($body, true);

        return array_map(
            fn (array $userData) => User::fromArray($userData),
            $body
        );
    }
}
