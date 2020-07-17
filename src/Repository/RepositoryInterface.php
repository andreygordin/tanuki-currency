<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Repository;

use TanukiCurrency\Entity\Code;
use TanukiCurrency\Entity\Currency;
use TanukiCurrency\Exception\CurrencyNotFoundException;

interface RepositoryInterface
{
    /**
     * @throws CurrencyNotFoundException
     */
    public function find(Code $code): Currency;

    public function save(Currency $currency): void;
}
