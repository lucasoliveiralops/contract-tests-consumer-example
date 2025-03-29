<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\NotificationFilter;
use App\Services\User\UserService;

class NotificationService
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function notify(NotificationFilter $filter): bool
    {
        $users = $this->userService->getByFilters($filter->age, $filter->gender);

        if (! $users) {
            return false;
        }

        return true;
    }
}
