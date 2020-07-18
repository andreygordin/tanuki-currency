<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Repository;

use TanukiCurrency\Entity\Currency;
use TanukiCurrency\Entity\CurrencyState;
use TanukiCurrency\Entity\Rate;

class DbRepository implements RepositoryInterface
{
    public function find(Currency $currency): CurrencyState
    {
        // @todo Implement retrieving the real data

        return new CurrencyState($currency, new Rate(mt_rand(1, 500) / 100));
    }

    public function save(CurrencyState $currencyState): void
    {
        // @todo Implement saving the data
    }
}
