<?php

declare(strict_types=1);

namespace Zim32\TestTask\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Zim32\TestTask\Contract\ExchangeRatesProviderInterface;

class DefaultExchangeRatesProvider implements ExchangeRatesProviderInterface
{
    /**
     * @var array<string, float>
     */
    protected array $cache = [];

    public function __construct(
        #[Autowire('%curr_converter_api_key%')] private readonly string $apiKey
    )
    {
    }

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

        $this->loadRatesIfNeeded();

        if (false === array_key_exists($to, $this->cache)) {
            throw new \Exception(sprintf('No exchange rate exists for %s currency', $to));
        }

        return $this->cache[$to];
    }

    public function hasCache(): bool
    {
        return !!$this->cache;
    }

    /**
     * @throws \Exception
     */
    public function loadRatesIfNeeded(): void
    {
        if ($this->cache) {
            return;
        }

        $context = [
            'http' => [
                'header' => [
                    'apikey: ' . $this->apiKey
                ]
            ]
        ];

        $response = file_get_contents(
            'https://api.apilayer.com/fixer/latest?base=EUR',
            false,
            stream_context_create($context)
        );

        if (!$response) {
            throw new \Exception('Can not load currency rates');
        }

        $response = json_decode($response, true);
        $this->cache = $response['rates'];
    }
}
