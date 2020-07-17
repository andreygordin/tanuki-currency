<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Test\Unit\Entity;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TanukiCurrency\Entity\Code;

class CodeTest extends TestCase
{
    public function testDefault(): void
    {
        $code = new Code($value = 'RUB');

        self::assertEquals($value, $code->value());
    }

    public function testLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Code('');

        $this->expectException(InvalidArgumentException::class);
        new Code('FOUR');
    }

    public function testCase(): void
    {
        $code = new Code('rub');

        self::assertEquals('RUB', $code->value());
    }
}
