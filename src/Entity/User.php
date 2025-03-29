<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\Gender;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $age,
        public readonly Gender $gender,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['age'],
            Gender::from($data['gender']),
        );
    }
}
