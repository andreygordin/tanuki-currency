<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Repository;

use InvalidArgumentException;
use TanukiCurrency\Entity\Currency;
use TanukiCurrency\Entity\CurrencyState;
use TanukiCurrency\Exception\CurrencyNotFoundException;
use TanukiCurrency\Exception\ReadOnlyException;

class ChainRepository implements RepositoryInterface
{
    /**
     * @var RepositoryInterface[]
     */
    private $repositories;

    public function __construct(RepositoryInterface ...$repositories)
    {
        if (empty($repositories)) {
            throw new InvalidArgumentException('At least one repository must be specified');
        }
        $this->repositories = $repositories;
    }

    public function find(Currency $currency): CurrencyState
    {
        return $this->findRecursive($currency);
    }

    public function save(CurrencyState $currencyState): void
    {
        throw new ReadOnlyException();
    }

    /**
     * @throws CurrencyNotFoundException
     */
    private function findRecursive(Currency $currency, ?RepositoryInterface $currentRepository = null): CurrencyState
    {
        if ($currentRepository === null) {
            $currentRepository = reset($this->repositories);
        }
        try {
            $currencyState = $currentRepository->find($currency);
        } catch (CurrencyNotFoundException $e) {
            if (false === $nextRepository = next($this->repositories)) {
                throw $e;
            }
            $currencyState = $this->findRecursive($currency, $nextRepository);
            try {
                $currentRepository->save($currencyState);
            } catch (ReadOnlyException $e) {
            }
        }
        return $currencyState;
    }
}
