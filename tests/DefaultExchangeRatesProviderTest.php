<?php

declare(strict_types=1);

use Zim32\TestTask\Exception\UnsupportedCurrencyCodeException;
use Zim32\TestTask\Service\DefaultExchangeRatesProvider;

require_once __DIR__ . '/../src/container.php';

class DefaultExchangeRatesProviderTest extends \PHPUnit\Framework\TestCase
{

    public function testExchangeRatesProvider(): void
    {
        $provider = new DefaultExchangeRatesProvider('dummy_api_key');

        // check that cache is empty
        $this->assertSame(false, $provider->hasCache());

        // test that exchange provider throws exception when invalid base currency in passed
        try {
            $provider->getRate('USD', 'UAH');
            $this->fail('Exception is not thrown');
        } catch (\Exception $e) {
            $this->assertInstanceOf(UnsupportedCurrencyCodeException::class, $e);
        }


        try {
            $provider->getRate('GBP', 'EUR');
            $this->fail('Exception is not thrown');
        } catch (\Exception $e) {
            $this->assertInstanceOf(UnsupportedCurrencyCodeException::class, $e);
        }

        // check that cache is empty
        $this->assertSame(false, $provider->hasCache());
    }

}
