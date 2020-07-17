<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Test\Unit\Handler;

use PHPUnit\Framework\TestCase;
use TanukiCurrency\Entity\Code;
use TanukiCurrency\Entity\Currency;
use TanukiCurrency\Entity\Rate;
use TanukiCurrency\Exception\CurrencyNotFoundException;
use TanukiCurrency\Exception\NoHandlersException;
use TanukiCurrency\Handler\HandlerBuilder;
use TanukiCurrency\Repository\RepositoryInterface;

class HandlerBuilderTest extends TestCase
{
    public function testFoundInFirstRepository(): void
    {
        $cacheRepository = $this->createMock(RepositoryInterface::class);
        $cacheRepository
            ->expects($this->once())
            ->method('find')->willReturn(
                $currencyFound = new Currency(new Code('RUB'), new Rate(0.014))
            );
        $cacheRepository->expects($this->never())->method('save');

        $dbRepository = $this->createMock(RepositoryInterface::class);
        $dbRepository->expects($this->never())->method('find');
        $dbRepository->expects($this->never())->method('save');

        $httpRepository = $this->createMock(RepositoryInterface::class);
        $httpRepository->expects($this->never())->method('find');
        $httpRepository->expects($this->never())->method('save');

        $handler = (new HandlerBuilder())
            ->with($cacheRepository)
            ->with($dbRepository)
            ->with($httpRepository)
            ->build();

        $currencyRetrieved = $handler->retrieveCurrency(new Code('RUB'));
        self::assertSame($currencyFound, $currencyRetrieved);
    }

    public function testFoundInLastRepository(): void
    {
        $cacheRepository = $this->createMock(RepositoryInterface::class);
        $cacheRepository
            ->expects($this->once())
            ->method('find')
            ->willThrowException(new CurrencyNotFoundException());
        $cacheRepository->expects($this->once())->method('save');

        $dbRepository = $this->createMock(RepositoryInterface::class);
        $dbRepository
            ->expects($this->once())
            ->method('find')
            ->willThrowException(new CurrencyNotFoundException());
        $dbRepository->expects($this->once())->method('save');

        $httpRepository = $this->createMock(RepositoryInterface::class);
        $httpRepository
            ->expects($this->once())
            ->method('find')->willReturn(
                $currencyFound = new Currency(new Code('RUB'), new Rate(0.014))
            );
        $httpRepository->expects($this->never())->method('save');

        $handler = (new HandlerBuilder())
            ->with($cacheRepository)
            ->with($dbRepository)
            ->with($httpRepository)
            ->build();

        $currencyRetrieved = $handler->retrieveCurrency(new Code('RUB'));
        self::assertSame($currencyFound, $currencyRetrieved);
    }

    public function testNotFound(): void
    {
        $cacheRepository = $this->createMock(RepositoryInterface::class);
        $cacheRepository
            ->expects($this->once())
            ->method('find')
            ->willThrowException(new CurrencyNotFoundException());
        $cacheRepository->expects($this->never())->method('save');

        $dbRepository = $this->createMock(RepositoryInterface::class);
        $dbRepository
            ->expects($this->once())
            ->method('find')
            ->willThrowException(new CurrencyNotFoundException());
        $dbRepository->expects($this->never())->method('save');

        $httpRepository = $this->createMock(RepositoryInterface::class);
        $httpRepository
            ->expects($this->once())
            ->method('find')->willThrowException(new CurrencyNotFoundException());
        $httpRepository->expects($this->never())->method('save');

        $handler = (new HandlerBuilder())
            ->with($cacheRepository)
            ->with($dbRepository)
            ->with($httpRepository)
            ->build();

        $this->expectException(CurrencyNotFoundException::class);
        $handler->retrieveCurrency(new Code('RUB'));
    }

    public function testNoHandlers(): void
    {
        $this->expectException(NoHandlersException::class);
        (new HandlerBuilder())->build();
    }
}
