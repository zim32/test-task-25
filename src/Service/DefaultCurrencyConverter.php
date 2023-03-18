<?php

declare(strict_types=1);

namespace Zim32\TestTask\Service;

use Zim32\TestTask\Contract\CurrencyConverterInterface;
use Zim32\TestTask\Contract\ExchangeRatesProviderInterface;

class DefaultCurrencyConverter implements CurrencyConverterInterface
{
    public function __construct(
        private readonly ExchangeRatesProviderInterface $exchangeRatesProvider,
    )
    {
    }

    public function convert(float $amount, string $from, string $to): float
    {
        if ($amount < 0) {
            throw new \Exception('Can not convert currency: amount is < 0');
        }

        $from = strtoupper($from);
        $to = strtoupper($to);

        if ($from === $to) {
            return $amount;
        }

        $rate = $this->exchangeRatesProvider->getRate($to, $from);

        if ($rate === 0.0) {
            return $amount;
        }

        return ceil($amount * 100 / $rate) / 100;
    }
}
