<?php

namespace App\Message\Command;

class AddCredit
{
    public function __construct(
        public readonly int $userId,
        public readonly int $amount
    ) {}
}
