<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Entity;

class CurrencyState
{
    /**
     * @var Currency
     */
    private $currency;

    /**
     * @var Rate
     */
    private $rate;

    public function __construct(Currency $currency, Rate $rate)
    {
        $this->currency = $currency;
        $this->rate = $rate;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function rate(): Rate
    {
        return $this->rate;
    }
}
