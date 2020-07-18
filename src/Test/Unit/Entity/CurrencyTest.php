<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Test\Unit\Entity;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TanukiCurrency\Entity\Currency;

class CurrencyTest extends TestCase
{
    public function testDefault(): void
    {
        $currency = new Currency($code = 'RUB');

        self::assertEquals($code, $currency->code());
    }

    public function testLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Currency('');

        $this->expectException(InvalidArgumentException::class);
        new Currency('FOUR');
    }

    public function testCase(): void
    {
        $currency = new Currency('rub');

        self::assertEquals('RUB', $currency->code());
    }
}
