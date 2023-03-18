<?php

declare(strict_types=1);

use Zim32\TestTask\Service\DefaultCurrencyConverter;
use Zim32\TestTask\Service\TestExchangeRatesProvider;

class DefaultCurrencyConverterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @throws Exception
     */
    public function testConversions(): void
    {
        $converter = new DefaultCurrencyConverter(new TestExchangeRatesProvider());

        $this->assertSame(100.0, $converter->convert(4800, 'UAH', 'EUR'));
        $this->assertSame(50.0, $converter->convert(2400, 'UAH', 'EUR'));
        $this->assertSame(25.0, $converter->convert(1200, 'UAH', 'EUR'));
        $this->assertSame(3.13, $converter->convert(150, 'UAH', 'EUR'));
        $this->assertSame(2.09, $converter->convert(100, 'UAH', 'EUR'));
        $this->assertSame(0.49, $converter->convert(23.31, 'UAH', 'EUR'));
        $this->assertSame(94.34, $converter->convert(100, 'USD', 'EUR'));
        $this->assertSame(47.17, $converter->convert(50, 'USD', 'EUR'));
        $this->assertSame(0.0, $converter->convert(0, 'UAH', 'EUR'));

        // check that exception is thrown if negative number is passed
        $this->expectException(\Exception::class);
        $converter->convert(-10, 'UAH', 'EUR');
    }

}
