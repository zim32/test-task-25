<?php

namespace Zim32\TestTask\Contract;

interface CurrencyConverterInterface
{
    public function convert(float $amount, string $from, string $to): float;
}
