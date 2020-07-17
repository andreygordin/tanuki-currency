<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Test\Unit\Entity;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TanukiCurrency\Entity\Rate;

class RateTest extends TestCase
{
    public function testDefault(): void
    {
        $rate = new Rate($value = 0.014);

        self::assertEquals($value, $rate->value());
    }

    public function testNonPositive(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Rate(0);

        $this->expectException(InvalidArgumentException::class);
        new Rate(-0.014);
    }
}
