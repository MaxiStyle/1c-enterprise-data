# Changelog

Все важные изменения в этом проекте будут документированы в этом файле.

Формат основан на [Keep a Changelog](https://keepachangelog.com/ru/1.0.0/),
и проект придерживается [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.1.2] - 2025-12-04

### Fixed
- Исправлены баги в генерации XML документов

## [1.1.1] - 2025-11-23

### Added
- Поддержка генерации XML с несколькими документами в одном Body
- Новый метод генерации для массива документов: `$generator->generate([$doc1, $doc2])`
- Пример использования множественных документов в `examples/invoice-out-multiple.php`

### Fixed
- Исправлены ошибки в DocumentGenerator при работе с несколькими документами
- Улучшена обработка ошибок валидации документов
- Оптимизирована архитектура для поддержки множественных документов

### Technical
- DocumentGenerator.php реорганизован для поддержки union types (object|array)
- Добавлена валидация всех документов в массиве перед генерацией
- Сохранена полная обратная совместимость с существующим API
- Все изменения протестированы и проверены на синтаксические ошибки

## [1.1.0] - 2025-11-09

### Added
- Реализация документа "Счёт от поставщика" (InvoiceIn)
- Исправлены ошибки

### Technical
- composer.json оптимизирован для публикации (убрано поле version)
- Добавлены репозитории VCS в composer.json
- Подтверждено соответствие PSR-12 (phpcs проходит без ошибок)
- Настроены инструменты контроля качества кода

## [1.0.0] - 2025-11-09

### Added
- Первая стабильная версия библиотеки
- Поддержка генерации XML документов в формате 1C EnterpriseData
- Реализация документа "Счёт покупателю" (InvoiceOut)
- Поддержка сущностей: Organization, Currency, InvoiceOut, Bank, BankAccount, Contract, Nomenclature, Product, ProductGroup, UnitOfMeasure
- Автоматическое форматирование XML с BOM для корректного отображения кириллицы в 1С
- Соответствие стандартам PSR-12
- Примеры использования в папке examples/

### Technical
- Требования: PHP >= 8.1, расширение DOM
- Автозагрузка по стандарту PSR-4
- Инструменты качества кода: PHP_CodeSniffer, PHPStan, PHP-CS-Fixer
- Лицензия MIT

[Unreleased]: https://github.com/maxistyle/1c-enterprise-data/compare/v1.1.2...HEAD
[1.1.2]: https://github.com/maxistyle/1c-enterprise-data/releases/tag/v1.1.2
[1.1.1]: https://github.com/maxistyle/1c-enterprise-data/releases/tag/v1.1.1
[1.1.0]: https://github.com/maxistyle/1c-enterprise-data/releases/tag/v1.1.0
[1.0.0]: https://github.com/maxistyle/1c-enterprise-data/releases/tag/v1.0.0