<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MaxiStyle\EnterpriseData\DocumentGenerator;
use MaxiStyle\EnterpriseData\Entities;
use MaxiStyle\EnterpriseData\Exception;

// Создаем счёт

// Организация
$organization = new Entities\Organization();
$organization->set('name', 'Торговый дом "Комплексный" ООО')
    ->set('shortName', 'ООО "Торговый дом "Комплексный"')
    ->set('fullName', 'Общество с ограниченной ответственностью "Торговый дом "Комплексный"')
    ->set('inn', '7799434926')
    ->set('kpp', '779901001')
    ;

// Контрагент
$counterparty = new Entities\Organization();
$counterparty->set('name', 'Конфетпром ООО')
    ->set('fullName', 'ООО "Конфетпром"')
    ->set('inn', '7799555550')
    ->set('kpp', '779901001')
;

// Валюта
$currency = new Entities\Currency();

// ДанныеВзаиморасчетов
// Договор
$contract = new Entities\Contract();
$contract->set('name', '7788/УЕ от 20.12.2014')
    ->set('organization', $organization)
    ->set('counterparty', $counterparty)
    ->set('currency', $currency)
    ->set('calculationsInConditionalUnits', 'false');

// Банк
$bank = new Entities\Bank();
$bank->set('bik', '044525225')
    ->set('corAccount', '30101810400000000225')
    ->set('name', 'ПАО СБЕРБАНК');

// Счет
$bankAccount = new Entities\BankAccount();
$bankAccount->set('accountNumber', '40702810399994349242')
    ->set('bank', $bank);



// Создаем товары

// Первый товар
// Группа номенклатуры для первого товара
$group1 = new Entities\ProductGroup();
$group1->set('name', 'Печенье')
    ->set('code', '00-00000031');

// Номенклатура первого товара
$nomenclature1 = new Entities\Nomenclature();
$nomenclature1->set('fullName', 'Вафли "Венские" с шоколадом')
    ->set('code', '00-00000039')
    ->set('name', 'Вафли "Венские" с шоколадом')
    ->set('group', $group1);

// Единица измерения
$unit1 = new Entities\UnitOfMeasure();
$unit1->set('code', '796')
    ->set('name', 'шт');

$product1 = new Entities\Product();
$product1->set('nomenclature', $nomenclature1)
    ->set('unitOfMeasure', $unit1)
    ->set('quantity', 3)
    ->set('amount', 210)
    ->set('price', 70)
    ->set('vatRate', 'НДС18')
    ->set('vatAmount', 32.03)
    ->set('stockType', 'СобственныеТовары');


// Второй товар
// Группа номенклатуры для второго товара
$group2 = new Entities\ProductGroup();
$group2->set('name', 'Конфеты')
    ->set('code', '00-00000001');

// Номенклатура второго товара
$nomenclature2 = new Entities\Nomenclature();
$nomenclature2->set('fullName', 'Конфеты "Батончик"')
    ->set('code', '00-00000038')
    ->set('name', 'Конфеты "Батончик"')
    ->set('group', $group2);

// Единица измерения для второго товара
$unit2 = new Entities\UnitOfMeasure();
$unit2->set('code', '796')
    ->set('name', 'шт');

$product2 = new Entities\Product();
$product2->set('nomenclature', $nomenclature2)
    ->set('unitOfMeasure', $unit2)
    ->set('quantity', 12)
    ->set('amount', 1800)
    ->set('price', 150)
    ->set('vatRate', 'НДС18')
    ->set('vatAmount', 274.58)
    ->set('stockType', 'СобственныеТовары');


// Весь документ
$invoice = new Entities\InvoiceIn();
$invoice->set('number', '0000-000524')
    ->set('date', new DateTime())
    ->set('organization', $organization)
    ->set('currency', $currency)
    ->set('amount', 2010)
    ->set('amountIncludesVat', 'true')
    ->set('counterparty', $counterparty)
    ->set('contract', $contract)
    ->set('bankAccount', $bankAccount)
    ->set('products', [$product1, $product2])
;

$generator = new DocumentGenerator();

try {
    $xml = $generator->generate($invoice);
    $generator->saveToFile($xml, './examples/invoice-in.xml');

    echo 'Счёт успешно сформирован';
} catch (Exception\UnsupportedDocumentException|Exception\XMLGenerationException $e) {
    echo $e->getMessage();
}
