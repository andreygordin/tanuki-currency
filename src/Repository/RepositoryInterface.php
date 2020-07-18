<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Repository;

use TanukiCurrency\Entity\Currency;
use TanukiCurrency\Entity\CurrencyState;
use TanukiCurrency\Exception\CurrencyNotFoundException;

interface RepositoryInterface
{
    /**
     * @throws CurrencyNotFoundException
     */
    public function find(Currency $currency): CurrencyState;

    public function save(CurrencyState $currencyState): void;
}
