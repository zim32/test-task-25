<?php

namespace Zim32\TestTask\Contract;

interface BinCountryResolverInterface
{
    public function getCountryCodeByBinNumber(string $bin): string|null;
}
