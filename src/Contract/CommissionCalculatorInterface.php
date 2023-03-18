<?php

namespace Zim32\TestTask\Contract;

use Zim32\TestTask\Dto\TransactionDto;

interface CommissionCalculatorInterface
{
    public function calculate(TransactionDto $transaction): float;
}
