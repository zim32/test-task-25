<?php

use Zim32\TestTask\Helper\EuDetector;

class EuDetectorTest extends \PHPUnit\Framework\TestCase
{

    public function testEuDetector(): void
    {
        $this->assertSame(true, EuDetector::isEU('DK'));
        $this->assertSame(true, EuDetector::isEU('dk'));
        $this->assertSame(false, EuDetector::isEU('UA'));
        $this->assertSame(false, EuDetector::isEU('us'));
        $this->assertSame(false, EuDetector::isEU('US'));
        $this->assertSame(false, EuDetector::isEU(''));
    }

}
