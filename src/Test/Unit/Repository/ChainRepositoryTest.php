<?php

/**
 * @copyright Copyright (c) 2020
 * @author Andrey Gordin <andrey@gordin.su>
 */

declare(strict_types=1);

namespace TanukiCurrency\Test\Unit\Repository;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TanukiCurrency\Entity\Currency;
use TanukiCurrency\Entity\CurrencyState;
use TanukiCurrency\Entity\Rate;
use TanukiCurrency\Exception\CurrencyNotFoundException;
use TanukiCurrency\Exception\ReadOnlyException;
use TanukiCurrency\Repository\ChainRepository;
use TanukiCurrency\Repository\RepositoryInterface;

class ChainRepositoryTest extends TestCase
{
    public function testFoundInFirstRepository(): void
    {
        $cacheRepository = $this->createMock(RepositoryInterface::class);
        $cacheRepository
            ->expects($this->once())
            ->method('find')->willReturn(
                $currencyStateFound = new CurrencyState(new Currency('RUB'), new Rate(0.014))
            );
        $cacheRepository->expects($this->never())->method('save');

        $dbRepository = $this->createMock(RepositoryInterface::class);
        $dbRepository->expects($this->never())->method('find');
        $dbRepository->expects($this->never())->method('save');

        $httpRepository = $this->createMock(RepositoryInterface::class);
        $httpRepository->expects($this->never())->method('find');
        $httpRepository->expects($this->never())->method('save');

        $chainRepository = new ChainRepository(
            $cacheRepository,
            $dbRepository,
            $httpRepository
        );

        $currencyStateRetrieved = $chainRepository->find(new Currency('RUB'));
        self::assertSame($currencyStateFound, $currencyStateRetrieved);
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
                $currencyStateFound = new CurrencyState(new Currency('RUB'), new Rate(0.014))
            );
        $httpRepository->expects($this->never())->method('save');

        $chainRepository = new ChainRepository(
            $cacheRepository,
            $dbRepository,
            $httpRepository
        );

        $currencyStateRetrieved = $chainRepository->find(new Currency('RUB'));
        self::assertSame($currencyStateFound, $currencyStateRetrieved);
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

        $chainRepository = new ChainRepository(
            $cacheRepository,
            $dbRepository,
            $httpRepository
        );

        $this->expectException(CurrencyNotFoundException::class);
        $chainRepository->find(new Currency('RUB'));
    }

    public function testNoRepositories(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ChainRepository();
    }

    public function testSaving(): void
    {
        $internalRepository = $this->createMock(RepositoryInterface::class);
        $chainRepository = new ChainRepository($internalRepository);
        $currencyState = $this->createMock(CurrencyState::class);

        $this->expectException(ReadOnlyException::class);
        $chainRepository->save($currencyState);
    }
}
