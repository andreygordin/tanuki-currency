<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Handler;

use TanukiCurrency\Exception\NoHandlersException;
use TanukiCurrency\Repository\RepositoryInterface;

class HandlerBuilder
{
    /**
     * @var RepositoryInterface[]
     */
    private $repositories = [];

    public function with(RepositoryInterface $repository): self
    {
        $this->repositories[] = $repository;
        return $this;
    }

    public function build(): Handler
    {
        if (empty($this->repositories)) {
            throw new NoHandlersException();
        }

        $handler = null;
        foreach (array_reverse($this->repositories) as $repository) {
            $handler = new Handler($repository, $handler);
        }
        return $handler;
    }
}
