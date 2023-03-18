<?php

declare(strict_types=1);

namespace Zim32\TestTask\App;

use Zim32\TestTask\Contract\CommissionCalculatorInterface;
use Zim32\TestTask\Service\FromFileTransactionsProvider;

class TestTaskApp
{
    public function __construct(
        private readonly CommissionCalculatorInterface $commissionCalculator
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        global $argc, $argv;

        if ($argc < 2) {
            throw new \Exception('Please specify transactions file');
        }

        $transactionsProvider = new FromFileTransactionsProvider($argv[1]);

        foreach ($transactionsProvider->getTransactions() as $transaction) {
            echo $this->commissionCalculator->calculate($transaction) . PHP_EOL;
        }
    }
}
