<?php

declare(strict_types=1);

namespace App\Entity;

class Notification
{
    public function __construct(
        public readonly User $user,
        public string $title,
        public string $description,
    ) {
    }
}
