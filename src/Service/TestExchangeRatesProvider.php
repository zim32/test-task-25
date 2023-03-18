<?php

namespace Zim32\TestTask\Service;

use Zim32\TestTask\Contract\ExchangeRatesProviderInterface;

class TestExchangeRatesProvider implements ExchangeRatesProviderInterface
{
    const TEST_CURRENCY_RATES = [
        'UAH' => 48,
        'USD' => 1.06,
        'JPY' => 140.591715,
        'GBP' => 0.875833,
    ];

    /**
     * @throws \Exception
     */
    public function getRate(string $baseCurrency, string $to): float
    {
        $baseCurrency = strtoupper($baseCurrency);
        $to = strtoupper($to);

        if ($baseCurrency !== 'EUR') {
            throw new \Exception('Only EUR is supported as base currency for exchange rates');
        }

        if (false === array_key_exists($to, self::TEST_CURRENCY_RATES)) {
            throw new \Exception('Unsupported test currency');
        }

        return self::TEST_CURRENCY_RATES[$to] ?? 0;
    }
}
