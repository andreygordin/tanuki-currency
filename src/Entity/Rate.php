<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Entity;

use InvalidArgumentException;

class Rate
{
    /**
     * @var float
     */
    private $value;

    public function __construct(float $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Currency rate must be greater than zero');
        }

        $this->value = $value;
    }

    public function value(): float
    {
        return $this->value;
    }
}
