<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Test\Unit\Entity;

use PHPUnit\Framework\TestCase;
use TanukiCurrency\Entity\Currency;
use TanukiCurrency\Entity\CurrencyState;
use TanukiCurrency\Entity\Rate;

class CurrencyStateTest extends TestCase
{
    public function testDefault(): void
    {
        $currencyState = new CurrencyState(
            new Currency($currencyCode = 'RUB'),
            new Rate($rateValue = 0.014)
        );

        self::assertInstanceOf(Currency::class, $currencyState->currency());
        self::assertEquals($currencyCode, $currencyState->currency()->code());

        self::assertInstanceOf(Rate::class, $currencyState->rate());
        self::assertEquals($rateValue, $currencyState->rate()->value());
    }
}
