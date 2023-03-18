<?php

namespace Zim32\TestTask\Exception;

use JetBrains\PhpStorm\Pure;

class NegativeNumberException extends \Exception
{
    #[Pure]
    public function __construct(float $number)
    {
        parent::__construct(sprintf("Negative number is not supporter. Provided value is %d", $number));
    }

}
