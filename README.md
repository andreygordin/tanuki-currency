# Тестовый проект для Тануки

## Что требовалось сделать

Есть большая система, которая приносит значительный доход компании и следовательно к качеству её кода предъявляются высокие требования.

Эта система, помимо всего прочего, использует курсы валют.

Логика получения курсов валют следующая. Вызывающий код может получить их из кеша, из базы данных и из внешнего источника по http. В случае, если курса валют нет в кеше, надо проверить базу, и если там есть, положить в кеш. Если в базе нет -- проверить внешний источник и положить и в базу, и в кеш.

Надо реализовать эту логику. Предполагается, что она будет использоваться в куче разных мест.

Вероятно, в условии есть неточности, какое-то поведение не указано и тд. Нужно самостоятельно принять решение что делать в каждом таком случае и явно это пометить -- либо в комментарии, либо в файле типа readme. В этом же файле напишите, что бы вы сделали по-другому, будь у вас больше времени; какие у вас были соображения, как в целом должен выглядеть этот код, к чему вы вообще стремились.

Функционал отправки запросов, хранения данных в базе и в кеше реализовывать не надо, вместо них достаточно сделать заглушки. Иными словами, не нужно реализовывать трудоемкие технические детали. Вместо этого важнее как вы декомпозировали предметную область, как выглядят ваши классы, куда вы поместили логику. Тем не менее, по качеству код должен выглядеть так, как будто вы отдаёте финальную его версию на ревью.

## Как запустить

Устанавливаем через Composer:

```
composer require andreygordin/tanuki-currency
```

Пример использования:

```php
use TanukiCurrency\Entity\Currency;
use TanukiCurrency\Repository\CacheRepository;
use TanukiCurrency\Repository\ChainRepository;
use TanukiCurrency\Repository\DbRepository;
use TanukiCurrency\Repository\HttpRepository;

$chainRepository = new ChainRepository(
	new CacheRepository(),
	new DbRepository(),
	new HttpRepository()
);

$currencyState = $chainRepository->find(new Currency('RUB'));

echo $currencyState->rate()->value();
```

## Как проверить

Для проверки кода линтером, из папки с кодом запустить:

```
composer lint
```

Для проверки кода через phpcs:

```
composer cs-check
```

Для проверки кода через psalm:

```
composer psalm
```

Для запуска тестов:

```
composer test
```

## Что еще можно было бы сделать

1. Сейчас классы трех внутренних репозиториев возвращают фейковые данные и по факту ничего не сохраняют. Следуюшим шагом было бы настроить каждый репозиторий под работу с определенным типом хранилища.
Для работы с кешем существует PSR-6: можно было бы ```CacheRepository``` сделать зависимым от ```Psr\Cache\CacheItemPoolInterface``` и использовать такой клиент для получения-сохранения данных.
Для работы с HTTP есть PSR-17 и PSR-18: в классе ```HttpRepository``` можно было бы сделать зависимости от ```Psr\Http\Message\RequestFactoryInterface``` и ```Psr\Http\Client\ClientInterface```.
Для работы с базой в PSR ничего нет, тут можно было бы написать свой интерфейс.

2. Сейчас при запросе данных для десяти разных валют будет сделано десять отдельных запросов и к кешу, и к базе, и к внешнему источнику по HTTP. Есть смысл сделать возможность запроса информации сразу для целой коллекции валют.

3. Код валюты сейчас валидируется только по количеству символов. Стоит загрузить список всех существующих валют и проверять по нему, чтобы нельзя было запросить трехбуквенную, но несуществующую валюту.
