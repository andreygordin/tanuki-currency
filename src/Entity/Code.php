<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Entity;

use InvalidArgumentException;

class Code
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        if (mb_strlen($value) !== 3) {
            throw new InvalidArgumentException('Currency code must contain exactly three characters');
        }

        $value = mb_strtoupper($value);

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
