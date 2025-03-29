<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enum\Gender;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class NotificationFilter
{
    public function __construct(
        #[NotBlank(message: 'Age is Required')]
        #[Type('int')]
        public readonly int $age,
        #[NotBlank()]
        #[Type(Gender::class)]
        public readonly Gender $gender,
        #[NotBlank()]
        #[Type('string')]
        public readonly string $title,
        #[NotBlank()]
        #[Type('string')]
        public readonly string $description,
    ) {
    }
}
