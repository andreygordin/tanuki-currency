<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Entity;

use InvalidArgumentException;

class Currency
{
    /**
     * @var string
     */
    private $code;

    public function __construct(string $code)
    {
        if (mb_strlen($code) !== 3) {
            throw new InvalidArgumentException('Currency code must contain exactly three characters');
        }

        $code = mb_strtoupper($code);

        $this->code = $code;
    }

    public function code(): string
    {
        return $this->code;
    }
}
