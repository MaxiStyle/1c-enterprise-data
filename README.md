# 1C EnterpriseData XML Generator

PHP библиотека для генерации XML файлов в формате 1C EnterpriseData для импорта в 1С.

## Возможности

- Генерация XML документов в формате 1C EnterpriseData
- Поддержка документов типа "Счёт покупателю" (InvoiceOut)
- Автоматическое форматирование XML с BOM для корректного отображения кириллицы в 1С
- Соответствие стандартам PSR-12
- Готовые примеры использования

## Установка

Установка через Composer:

```bash
composer require maxistyle/1c-enterprise-data
```

## Требования

- PHP >= 8.1
- Расширение PHP DOM

## Быстрый старт

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use MaxiStyle\EnterpriseData\DocumentGenerator;
use MaxiStyle\EnterpriseData\Entities;

// Создаем организацию
$organization = new Entities\Organization();
$organization->set('name', 'Торговый дом "Комплексный" ООО')
    ->set('shortName', 'ООО "Торговый дом "Комплексный"')
    ->set('fullName', 'Общество с ограниченной ответственностью "Торговый дом "Комплексный"')
    ->set('inn', '7799434926')
    ->set('kpp', '779901001');

// Создаем контрагента
$counterparty = new Entities\Organization();
$counterparty->set('name', 'Этнопарк Перун')
    ->set('shortName', 'ООО "Этнопарк "Перун"')
    ->set('fullName', 'ООО "Этнопарк "Перун"')
    ->set('inn', '5099891610')
    ->set('kpp', '509901001');

// Валюта
$currency = new Entities\Currency();

// Создаем счёт
$invoice = new Entities\InvoiceOut();
$invoice->set('number', '0000-000524')
    ->set('date', new DateTime())
    ->set('organization', $organization)
    ->set('currency', $currency)
    ->set('amount', 2010)
    ->set('counterparty', $counterparty);

// Генерируем XML
$generator = new DocumentGenerator();
$xml = $generator->generate($invoice);

// Сохраняем в файл
$generator->saveToFile($xml, 'invoice.xml');

echo 'Счёт успешно сформирован!';
```

## Полный пример с товарами

Посмотрите файл `examples/invoice-out.php` для полного примера с товарами, банковскими реквизитами и договорами.

## Структура проекта

```
src/
├── Builders/               # Конструкторы документов
│   ├── DocumentBuilder.php
│   ├── DocumentBuilderInterface.php
│   └── InvoiceOutBuilder.php
├── Entities/               # Сущности данных
│   ├── Act.php
│   ├── Bank.php
│   ├── BankAccount.php
│   ├── Contract.php
│   ├── Currency.php
│   ├── Document.php
│   ├── InvoiceOut.php
│   ├── InvoiceProduct.php
│   ├── Nomenclature.php
│   ├── Organization.php
│   ├── ProductGroup.php
│   ├── UnitOfMeasure.php
│   └── Upd.php
├── Exception/              # Исключения
│   ├── UnsupportedDocumentException.php
│   └── XMLGenerationException.php
└── DocumentGenerator.php   # Основной класс генератора
```

## Поддерживаемые документы

### Счёт покупателю (InvoiceOut)

Генерирует XML в формате `Документ.ЗаказКлиента` со следующими элементами:

- **Ключевые свойства**: дата, номер, организация
- **Валюта**: код и наименование
- **Сумма**: общая сумма документа
- **Контрагент**: покупатель
- **Данные взаиморасчетов**: договор, валюта расчётов
- **Банковский счёт организации**: реквизиты для оплаты
- **Товары**: детальный список номенклатуры с ценами и НДС

## Качество кода

Проект соответствует стандартам PSR-12 и проходит автоматическую проверку:

```bash
# Проверка соответствия PSR-12
./vendor/bin/phpcs --standard=PSR12 src/

# Автоматическое исправление
./vendor/bin/phpcbf --standard=PSR12 src/
```

## Лицензия

MIT License

## Автор

MaxiStyle - tiranmax@yandex.ru

## Примеры

В папке `examples/` находятся готовые примеры использования:

- `invoice-out.php` - пример генерации счёта с товарами
- `invoice-out.xml` - сгенерированный XML файл

## Вклад в проект

1. Форкните репозиторий
2. Создайте ветку для новой функции
3. Внесите изменения
4. Убедитесь, что код проходит проверки PSR-12
5. Создайте Pull Request