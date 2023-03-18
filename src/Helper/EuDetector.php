<?php

namespace Zim32\TestTask\Helper;

class EuDetector
{
    public static function isEU(string $countryCode): bool
    {
        static $euCountries = ['AT','BE','BG','CY','CZ','DE','DK','EE','ES','FI','FR','GR','HR','HU','IE','IT','LT','LU','LV','MT','NL','PO','PT','RO','SE','SI','SK'];

        return in_array(strtoupper($countryCode), $euCountries);
    }
}
