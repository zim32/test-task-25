<?php

namespace Zim32\TestTask\Exception;

use JetBrains\PhpStorm\Pure;

class UnsupportedCurrencyCodeException extends \Exception
{
    #[Pure]
    public function __construct(string $currencyCode)
    {
        parent::__construct("Invalid currency code: " . $currencyCode);
    }

}
