<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Zim32\TestTask\Service\DefaultBinCountryResolver;

require_once __DIR__ . '/../src/container.php';

class DefaultBinCountryResolverTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testBins(): void
    {
        $binResolver = new DefaultBinCountryResolver();

        // test that resolver throws exception if invalid bin number is passed
        $this->expectException(\Exception::class);
        $binResolver->getCountryCodeByBinNumber('13471878');
    }
}
