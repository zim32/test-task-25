<?php

namespace Zim32\TestTask\Contract;

interface ExchangeRatesProviderInterface
{
    /**
     * @param string $baseCurrency
     * @param string $to
     * @return float
     */
    public function getRate(string $baseCurrency, string $to): float;
}
