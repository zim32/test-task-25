<?php

namespace Zim32\TestTask\Service;

use Zim32\TestTask\Contract\TransactionsProviderInterface;
use Zim32\TestTask\Dto\TransactionDto;

class FromFileTransactionsProvider implements TransactionsProviderInterface
{
    public function __construct(private readonly string $filePath)
    {
    }

    /**
     * @throws \Exception
     */
    public function getTransactions(): \Generator
    {
        if (!file_exists($this->filePath) || !is_readable($this->filePath)) {
            throw new \Exception(sprintf('Cat not load transactions: file "%s" is not readable or does not exist', $this->filePath));
        }

        $f = fopen($this->filePath, 'r');

        while (($line = fgets($f)) !== false) {
            if (!trim($line)) {
                break;
            }

            yield TransactionDto::fromArray(json_decode($line, true));
        }
    }
}
