<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Entity;

class Currency
{
    /**
     * @var Code
     */
    private $code;

    /**
     * @var Rate
     */
    private $rate;

    public function __construct(Code $code, Rate $rate)
    {
        $this->code = $code;
        $this->rate = $rate;
    }

    public function code(): Code
    {
        return $this->code;
    }

    public function rate(): Rate
    {
        return $this->rate;
    }
}
