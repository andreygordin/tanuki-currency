<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Test\Unit\Entity;

use PHPUnit\Framework\TestCase;
use TanukiCurrency\Entity\Code;
use TanukiCurrency\Entity\Currency;
use TanukiCurrency\Entity\Rate;

class CurrencyTest extends TestCase
{
    public function testDefault(): void
    {
        $currency = new Currency(
            new Code($codeValue = 'RUB'),
            new Rate($rateValue = 0.014)
        );

        self::assertInstanceOf(Code::class, $currency->code());
        self::assertEquals($codeValue, $currency->code()->value());

        self::assertInstanceOf(Rate::class, $currency->rate());
        self::assertEquals($rateValue, $currency->rate()->value());
    }
}
