<?php

declare(strict_types=1);

namespace Zim32\TestTask\Dto;

final class TransactionDto
{
    public function __construct(
        public readonly string $bin,
        public readonly float $amount,
        public readonly string $currency,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            bin: $data['bin'],
            amount: (float)$data['amount'],
            currency: strtoupper($data['currency']),
        );
    }
}
