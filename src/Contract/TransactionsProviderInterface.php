<?php

namespace Zim32\TestTask\Contract;

use Zim32\TestTask\Dto\TransactionDto;

interface TransactionsProviderInterface
{

    /**
     * @return \Generator|TransactionDto[]
     */
    public function getTransactions(): \Generator;

}
