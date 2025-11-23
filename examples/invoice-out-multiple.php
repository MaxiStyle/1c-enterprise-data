<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MaxiStyle\EnterpriseData\DocumentGenerator;
use MaxiStyle\EnterpriseData\Entities;
use MaxiStyle\EnterpriseData\Exception;

// =====================================
// СОЗДАНИЕ ПЕРВОГО СЧЁТА (СЧЁТ ПОКУПАТЕЛЮ)
// =====================================

echo "Создаём первый счёт (счёт покупателю)...
";

// Организация для первого счёта
$organization1 = new Entities\Organization();
$organization1->set('name', 'Торговый дом "Комплексный" ООО')
    ->set('shortName', 'Торговый дом "Комплексный" ООО')
    ->set('fullName', 'Торговый дом "Комплексный" ООО')
    ->set('inn', '7799434926')
    ->set('kpp', '779901001');

// Контрагент для первого счёта
$counterparty1 = new Entities\Organization();
$counterparty1->set('name', 'Этнопарк Перун ООО')
    ->set('shortName', 'Этнопарк Перун ООО')
    ->set('fullName', 'Этнопарк Перун ООО')
    ->set('inn', '5099891610')
    ->set('kpp', '509901001');

// Валюта для первого счёта
$currency1 = new Entities\Currency();

// Ответственный для первого счёта
$responsible1 = new Entities\Responsible();
$responsible1->set('name', 'Иванов Иван Иванович');

// Договор для первого счёта
$contract1 = new Entities\Contract();
$contract1->set('name', 'С покупателем - руб.')
    ->set('organization', $organization1)
    ->set('counterparty', $counterparty1)
    ->set('currency', $currency1)
    ->set('calculationsInConditionalUnits', 'false')
    ->set('date', '2022-01-31')
    ->set('number', 'У/0008/БМ');

// Банковский счёт для первого счёта
$bank1 = new Entities\Bank();
$bank1->set('bik', '044525225')
    ->set('corAccount', '30101810400000000225')
    ->set('name', 'ПАО СБЕРБАНК');

$bankAccount1 = new Entities\BankAccount();
$bankAccount1->set('accountNumber', '40702810399994349242')
    ->set('bank', $bank1);

// Товары для первого счёта
// Товар 1
$group1 = new Entities\ProductGroup();
$group1->set('name', 'Печенье')
    ->set('code', '00-00000031');

$nomenclature1 = new Entities\Nomenclature();
$nomenclature1->set('fullName', 'Вафли "Венские" с шоколадом')
    ->set('code', '00-00000039')
    ->set('name', 'Вафли "Венские" с шоколадом')
    ->set('group', $group1);

$unit1 = new Entities\UnitOfMeasure();
$unit1->set('code', '796')
    ->set('name', 'шт');

$product1 = new Entities\Product();
$product1->set('nomenclature', $nomenclature1)
    ->set('unitOfMeasure', $unit1)
    ->set('quantity', 1)
    ->set('amount', 70.0)
    ->set('price', 70.0)
    ->set('vatRate', 'НДС18')
    ->set('vatAmount', 12.6)
    ->set('stockType', 'СобственныеТовары');

// Товар 2
$group2 = new Entities\ProductGroup();
$group2->set('name', 'Конфеты')
    ->set('code', '00-00000001');

$nomenclature2 = new Entities\Nomenclature();
$nomenclature2->set('fullName', 'Конфеты "Батончик"')
    ->set('code', '00-00000038')
    ->set('name', 'Конфеты "Батончик"')
    ->set('group', $group2);

$unit2 = new Entities\UnitOfMeasure();
$unit2->set('code', '796')
    ->set('name', 'шт');

$product2 = new Entities\Product();
$product2->set('nomenclature', $nomenclature2)
    ->set('unitOfMeasure', $unit2)
    ->set('quantity', 1)
    ->set('amount', 150.0)
    ->set('price', 150.0)
    ->set('vatRate', 'НДС18')
    ->set('vatAmount', 27.0)
    ->set('stockType', 'СобственныеТовары');

// Сам первый счёт
$invoiceOut1 = new Entities\InvoiceOut();
$invoiceOut1->set('number', '0000-000524')
    ->set('date', new DateTime())
    ->set('organization', $organization1)
    ->set('currency', $currency1)
    ->set('responsible', $responsible1)
    ->set('amount', 220.0)
    ->set('amountIncludesVat', 'true')
    ->set('counterparty', $counterparty1)
    ->set('contract', $contract1)
    ->set('bankAccount', $bankAccount1)
    ->set('products', [$product1, $product2]);

echo "Первый счёт создан.\n";

// =====================================
// СОЗДАНИЕ ВТОРОГО СЧЁТА (СЧЁТ ОТ ПОСТАВЩИКА)
// =====================================

echo "Создаём второй счёт (счёт от поставщика)...
";

// Организация для второго счёта
$organization2 = new Entities\Organization();
$organization2->set('name', 'Торговый дом "Альфа" ООО')
    ->set('shortName', 'Торговый дом "Альфа" ООО')
    ->set('fullName', 'Торговый дом "Альфа" ООО')
    ->set('inn', '7712345678')
    ->set('kpp', '771201001');

// Контрагент для второго счёта
$counterparty2 = new Entities\Organization();
$counterparty2->set('name', 'Поставщик Бета ООО')
    ->set('shortName', 'Поставщик Бета ООО')
    ->set('fullName', 'Поставщик Бета ООО')
    ->set('inn', '5012345678')
    ->set('kpp', '501201001');

// Валюта для второго счёта
$currency2 = new Entities\Currency();

// Ответственный для второго счёта
$responsible2 = new Entities\Responsible();
$responsible2->set('name', 'Петров Пётр Петрович');

// Договор для второго счёта
$contract2 = new Entities\Contract();
$contract2->set('name', 'С поставщиком - руб.')
    ->set('organization', $organization2)
    ->set('counterparty', $counterparty2)
    ->set('currency', $currency2)
    ->set('calculationsInConditionalUnits', 'false')
    ->set('date', '2022-02-01')
    ->set('number', 'У/0009/БМ');

// Банковский счёт для второго счёта
$bank2 = new Entities\Bank();
$bank2->set('bik', '044525225')
    ->set('corAccount', '30101810400000000225')
    ->set('name', 'ПАО СБЕРБАНК');

$bankAccount2 = new Entities\BankAccount();
$bankAccount2->set('accountNumber', '40702810399994349242')
    ->set('bank', $bank2);

// Товары для второго счёта
// Товар 3
$group3 = new Entities\ProductGroup();
$group3->set('name', 'Напитки')
    ->set('code', '00-00000050');

$nomenclature3 = new Entities\Nomenclature();
$nomenclature3->set('fullName', 'Кофе "Арабика"')
    ->set('code', '00-00000100')
    ->set('name', 'Кофе "Арабика"')
    ->set('group', $group3);

$unit3 = new Entities\UnitOfMeasure();
$unit3->set('code', '796')
    ->set('name', 'шт');

$product3 = new Entities\Product();
$product3->set('nomenclature', $nomenclature3)
    ->set('unitOfMeasure', $unit3)
    ->set('quantity', 1)
    ->set('amount', 500.0)
    ->set('price', 500.0)
    ->set('vatRate', 'НДС18')
    ->set('vatAmount', 90.0)
    ->set('stockType', 'СобственныеТовары');

// Товар 4
$group4 = new Entities\ProductGroup();
$group4->set('name', 'Напитки')
    ->set('code', '00-00000050');

$nomenclature4 = new Entities\Nomenclature();
$nomenclature4->set('fullName', 'Чай "Зелёный"')
    ->set('code', '00-00000101')
    ->set('name', 'Чай "Зелёный"')
    ->set('group', $group4);

$unit4 = new Entities\UnitOfMeasure();
$unit4->set('code', '796')
    ->set('name', 'шт');

$product4 = new Entities\Product();
$product4->set('nomenclature', $nomenclature4)
    ->set('unitOfMeasure', $unit4)
    ->set('quantity', 1)
    ->set('amount', 300.0)
    ->set('price', 300.0)
    ->set('vatRate', 'НДС18')
    ->set('vatAmount', 54.0)
    ->set('stockType', 'СобственныеТовары');

// Сам второй счёт
$invoiceIn = new Entities\InvoiceIn();
$invoiceIn->set('number', '0000-000525')
    ->set('date', new DateTime())
    ->set('organization', $organization2)
    ->set('currency', $currency2)
    ->set('responsible', $responsible2)
    ->set('amount', 800.0)
    ->set('amountIncludesVat', 'true')
    ->set('counterparty', $counterparty2)
    ->set('contract', $contract2)
    ->set('bankAccount', $bankAccount2)
    ->set('products', [$product3, $product4]);

echo "Второй счёт создан.\n";

// =====================================
// ГЕНЕРАЦИЯ XML С НЕСКОЛЬКИМИ ДОКУМЕНТАМИ
// =====================================

echo "Генерируем XML с несколькими документами...\n";

// Создаём генератор документов
$generator = new DocumentGenerator();

// Создаём массив с двумя документами
$documents = [$invoiceOut1, $invoiceIn];

try {
    // Генерируем XML с несколькими документами в Body
    $xml = $generator->generate($documents);
    
    // Сохраняем в файл
    $generator->saveToFile($xml, __DIR__ . '/invoice-out-multiple.xml');
    
    echo "Успешно создан XML с несколькими документами!\n";
    echo "Файл сохранён как invoice-out-multiple.xml\n";
} catch (Exception\UnsupportedDocumentException|Exception\XMLGenerationException $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Неожиданная ошибка: " . $e->getMessage() . "\n";
}