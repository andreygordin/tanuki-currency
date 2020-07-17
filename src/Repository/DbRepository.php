<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Repository;

use TanukiCurrency\Entity\Code;
use TanukiCurrency\Entity\Currency;
use TanukiCurrency\Entity\Rate;

class DbRepository implements RepositoryInterface
{
    public function find(Code $code): Currency
    {
        // @todo Implement retrieving the real data

        return new Currency($code, new Rate(mt_rand(1, 500) / 100));
    }

    public function save(Currency $currency): void
    {
        // @todo Implement saving the data
    }
}
