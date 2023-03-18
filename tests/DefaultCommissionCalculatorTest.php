<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\DataProvider;
use Zim32\TestTask\Contract\BinCountryResolverInterface;
use Zim32\TestTask\Contract\CurrencyConverterInterface;
use Zim32\TestTask\Dto\TransactionDto;
use Zim32\TestTask\Service\DefaultCommissionCalculator;

class DefaultCommissionCalculatorTest extends \PHPUnit\Framework\TestCase
{
    public static function provideData(): array
    {
        return [
            [
                'bin' => '45717360',
                'amount' => 100.0,
                'currency' => 'EUR',
                'expectedResult' => 1.0,
                'country' => 'DK',
                'conversion' => 100.0,
                'expectedBinCountryCalls' => 1,
                'expectedConversionCalls' => 0,
            ],
            [
                'bin' => '516793',
                'amount' => 50.0,
                'currency' => 'USD',
                'expectedResult' => 0.95,
                'country' => 'LT',
                'conversion' => 94.34,
                'expectedBinCountryCalls' => 1,
                'expectedConversionCalls' => 1,
            ],
            [
                'bin' => '45417360',
                'amount' => 10000.00,
                'currency' => 'JPY',
                'expectedResult' => 1.43,
                'country' => 'JP',
                'conversion' => 71.13,
                'expectedBinCountryCalls' => 1,
                'expectedConversionCalls' => 1,
            ],
            [
                'bin' => '41417360',
                'amount' => 130.0,
                'currency' => 'USD',
                'expectedResult' => 2.46,
                'country' => 'US',
                'conversion' => 122.65,
                'expectedBinCountryCalls' => 1,
                'expectedConversionCalls' => 1,
            ],
            [
                'bin' => '4745030',
                'amount' => 2000.0,
                'currency' => 'GBP',
                'expectedResult' => 45.68,
                'country' => 'GB',
                'conversion' => 2283.55,
                'expectedBinCountryCalls' => 1,
                'expectedConversionCalls' => 1,
            ],
            [
                'bin' => '4745030',
                'amount' => 0.0,
                'currency' => 'GBP',
                'expectedResult' => 0.0,
                'country' => 'GB',
                'conversion' => 0.0,
                'expectedBinCountryCalls' => 0,
                'expectedConversionCalls' => 0,
            ]
        ];
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('provideData')]
    public function testCalculator(string $bin, float $amount, string $currency, float $expectedCommission, string $country, float $conversion, int $expectedBinCountryCalls, int $expectedConversionCalls): void
    {
        $binDataProvider = $this->createMock(BinCountryResolverInterface::class);
        $binDataProvider->expects($this->exactly($expectedBinCountryCalls))->method('getCountryCodeByBinNumber')->willReturn($country);

        $currencyConverter = $this->createMock(CurrencyConverterInterface::class);
        $currencyConverter->expects($this->exactly($expectedConversionCalls))->method('convert')->willReturn($conversion);

        $calculator = new DefaultCommissionCalculator($binDataProvider, $currencyConverter);

        $this->assertSame($expectedCommission, $calculator->calculate(
            new TransactionDto(bin: $bin, amount: $amount, currency: $currency )
        ));
    }

    public function testNegativeNumber(): void
    {
        $binDataProvider = $this->createStub(BinCountryResolverInterface::class);
        $binDataProvider->method('getCountryCodeByBinNumber')->willReturn('DK');

        $currencyConverter = $this->createStub(CurrencyConverterInterface::class);

        $calculator = new DefaultCommissionCalculator($binDataProvider, $currencyConverter);

        $this->expectExceptionMessage('Can not calculate commission: transaction amount < 0');

        $calculator->calculate(
            new TransactionDto(bin: '1234123', amount: -10.0, currency: 'EUR' )
        );
    }
}
