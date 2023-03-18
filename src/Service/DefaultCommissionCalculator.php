<?php

declare(strict_types=1);

namespace Zim32\TestTask\Service;

use Zim32\TestTask\Contract\BinCountryResolverInterface;
use Zim32\TestTask\Contract\CommissionCalculatorInterface;
use Zim32\TestTask\Contract\CurrencyConverterInterface;
use Zim32\TestTask\Dto\TransactionDto;
use Zim32\TestTask\Exception\NegativeNumberException;
use Zim32\TestTask\Helper\EuDetector;

class DefaultCommissionCalculator implements CommissionCalculatorInterface
{
    public function __construct(
        private readonly BinCountryResolverInterface $binDataProvider,
        private readonly CurrencyConverterInterface  $currencyConverter,
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function calculate(TransactionDto $transaction): float
    {
        if ($transaction->amount === 0.0) {
            return 0.0;
        }

        if ($transaction->amount < 0) {
            throw new NegativeNumberException($transaction->amount);
        }

        // detect country code from bin number
        $countryCode = $this->binDataProvider->getCountryCodeByBinNumber($transaction->bin);

        if (!$countryCode) {
            throw new \Exception('Can not calculate commission: can not detect country code from BIN');
        }

        $isEu = EuDetector::isEU($countryCode);

        $amountFixed = $transaction->currency === 'EUR' ?
                $transaction->amount :
                $this->currencyConverter->convert($transaction->amount, $transaction->currency, 'EUR');

        $result = $amountFixed * ($isEu ? 0.01 : 0.02);

        return ceil($result * 100) / 100;
    }
}
