<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Handler;

use TanukiCurrency\Entity\Code;
use TanukiCurrency\Entity\Currency;
use TanukiCurrency\Exception\CurrencyNotFoundException;
use TanukiCurrency\Repository\RepositoryInterface;

class Handler
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var self|null
     */
    private $nextHandler = null;

    public function __construct(RepositoryInterface $repository, self $nextHandler = null)
    {
        $this->repository = $repository;
        $this->nextHandler = $nextHandler;
    }

    public function retrieveCurrency(Code $code): Currency
    {
        try {
            $currency = $this->findCurrency($code);
        } catch (CurrencyNotFoundException $e) {
            if ($this->nextHandler) {
                $currency = $this->nextHandler->retrieveCurrency($code);
                $this->saveCurrency($currency);
            } else {
                throw $e;
            }
        }
        return $currency;
    }

    private function findCurrency(Code $code): Currency
    {
        return $this->repository->find($code);
    }

    private function saveCurrency(Currency $currency): void
    {
        $this->repository->save($currency);
    }
}
