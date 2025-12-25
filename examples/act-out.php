<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MaxiStyle\EnterpriseData\DocumentGenerator;
use MaxiStyle\EnterpriseData\Entities;
use MaxiStyle\EnterpriseData\Exception;

// Исходящий акт

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
$counterparty->set('name', 'Антикафе Земляника')
    ->set('fullName', 'ООО "Антикафе "Земляника"')
    ->set('inn', '7799543097')
    ->set('kpp', '779901001')
;

// Валюта
$currency = new Entities\Currency();

// Ответственный
$responsible = new Entities\Responsible();
$responsible->set('name', 'Абрамов Геннадий Сергеевич');

// Подразделение
$department = new Entities\Department();
$department->set('name', 'Головное подразделение');

// Склад
$warehouse = new Entities\Warehouse();
$warehouse->set('name', 'Основной склад');
$warehouse->set('type', 'Оптовый');

// ДанныеВзаиморасчетов
// Договор
$contract = new Entities\Contract();
$contract->set('name', 'С покупателем - руб.')
    ->set('organization', $organization)
    ->set('counterparty', $counterparty)
    ->set('currency', $currency)
    ->set('calculationsInConditionalUnits', 'false')
    ->set('contractType', 'СПокупателем')
;

// Банк
$bank = new Entities\Bank();
$bank->set('bik', '044525225')
    ->set('corAccount', '30101810400000000225')
    ->set('name', 'ПАО СБЕРБАНК');

// Счет
$bankAccount = new Entities\BankAccount();
$bankAccount->set('accountNumber', '40702810399994349242')
    ->set('bank', $bank);


// Заказ
$order = new Entities\Order();
$order->set('date', new DateTime())
      ->set('number', '0000-000001')
      ->set('organization', $organization);


// Создаем товары

// Группа номенклатуры
$group = new Entities\ProductGroup();
$group->set('name', 'Печенье')
    ->set('code', '00-00000031')
    ->set('link', '2b5e5e9f-1dcf-11e6-a31d-14dae9b19a48');

// Единица измерения
$unit = new Entities\UnitOfMeasure();
$unit->set('code', '796')
    ->set('name', 'шт');

// Товар 1: Миникруассаны классические
$nomenclature1 = new Entities\Nomenclature();
$nomenclature1->set('fullName', 'Миникруассаны классические')
    ->set('code', '00-00000034')
    ->set('name', 'Миникруассаны классические')
    ->set('group', $group);

$product1 = new Entities\Product();
$product1->set('nomenclature', $nomenclature1)
    ->set('unitOfMeasure', $unit)
    ->set('quantity', 5)
    ->set('amount', 1750)
    ->set('price', 350)
    ->set('vatRate', 'НДС20')
    ->set('vatAmount', 266.95)
    ->set('stockType', 'СобственныеТовары');

// Товар 2: Вафли "Венские" со сгущенным молоком
$nomenclature2 = new Entities\Nomenclature();
$nomenclature2->set('fullName', 'Вафли "Венские" со сгущенным молоком')
    ->set('code', '00-00000040')
    ->set('name', 'Вафли "Венские" со сгущенным молоком')
    ->set('group', $group);

$product2 = new Entities\Product();
$product2->set('nomenclature', $nomenclature2)
    ->set('unitOfMeasure', $unit)
    ->set('quantity', 105)
    ->set('amount', 9450)
    ->set('price', 90)
    ->set('vatRate', 'НДС20')
    ->set('vatAmount', 1441.53)
    ->set('stockType', 'СобственныеТовары');

// Товар 3: Миникруассаны с клубничным джемом
$nomenclature3 = new Entities\Nomenclature();
$nomenclature3->set('fullName', 'Миникруассаны с клубничным джемом')
    ->set('code', '00-00000041')
    ->set('name', 'Миникруассаны с клубничным джемом')
    ->set('group', $group);

$product3 = new Entities\Product();
$product3->set('nomenclature', $nomenclature3)
    ->set('unitOfMeasure', $unit)
    ->set('quantity', 52)
    ->set('amount', 6760)
    ->set('price', 130)
    ->set('vatRate', 'НДС20')
    ->set('vatAmount', 1031.19)
    ->set('stockType', 'СобственныеТовары');

// Товар 4: Пирог тирольский с вишней
$nomenclature4 = new Entities\Nomenclature();
$nomenclature4->set('fullName', 'Пирог тирольский с вишней')
    ->set('code', '00-00000035')
    ->set('name', 'Пирог тирольский с вишней')
    ->set('group', $group);

$product4 = new Entities\Product();
$product4->set('nomenclature', $nomenclature4)
    ->set('unitOfMeasure', $unit)
    ->set('quantity', 14)
    ->set('amount', 2940)
    ->set('price', 210)
    ->set('vatRate', 'НДС20')
    ->set('vatAmount', 448.47)
    ->set('stockType', 'СобственныеТовары');


// Весь документ
$act = new Entities\ActOut();
$act->set('number', '0000-000001')
    ->set('date', new DateTime('2025-12-10T12:00:00'))
    ->set('organization', $organization)
    ->set('currency', $currency)
    ->set('responsible', $responsible)
    ->set('amount', 33950)
    ->set('amountIncludesVat', true)
    ->set('counterparty', $counterparty)
    ->set('contract', $contract)
    ->set('bankAccount', $bankAccount)
    ->set('products', [$product1, $product2, $product3, $product4])
    ->set('department', $department)
    ->set('warehouse', $warehouse)
    ->set('proxyDate', '2015-01-09') // Доверенность Дата
    ->set('proxyNumber', '45094') // ДоверенностьНомер
    ->set('taxation', 'ПродажаОблагаетсяНДС')
    ->set('debtRepaymentMethod', 'Автоматически')
    ->set('order', $order)
;

$generator = new DocumentGenerator();

try {
    $xml = $generator->generate($act);
    $generator->saveToFile($xml, './examples/act-out.xml');

    echo 'Акт успешно сформирован в файл act-out.xml';
} catch (Exception\UnsupportedDocumentException|Exception\XMLGenerationException $e) {
    echo $e->getMessage();
}