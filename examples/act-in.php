<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MaxiStyle\EnterpriseData\DocumentGenerator;
use MaxiStyle\EnterpriseData\Entities;
use MaxiStyle\EnterpriseData\Exception;

// Входящий акт

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

// Ответственный
$responsible = new Entities\Responsible();
$responsible->set('name', 'Епифанцев Максим Леонидович');

// ДанныеВзаиморасчетов
// Договор
$contract = new Entities\Contract();
$contract->set('name', '7788/УЕ от 20.12.2014')
    ->set('organization', $organization)
    ->set('counterparty', $counterparty)
    ->set('currency', $currency)
    ->set('calculationsInConditionalUnits', 'false');

// Создаем услугу

// Номенклатура услуги
$nomenclature = new Entities\Nomenclature();
$nomenclature->set('fullName', 'Перевозка')
    ->set('code', '000000001')
    ->set('name', 'Перевозка')
    ->set('link', '3483717d-27d8-11ea-80c1-00155d062126');

// Услуга: Перевозка
$service = new Entities\Service();
$service->set('nomenclature', $nomenclature)
    ->set('quantity', 1)
    ->set('amount', 425000)
    ->set('price', 425000)
    ->set('vatRate', 'НДС20')
    ->set('vatAmount', 70833.33)
    ->set('description', 'Перевозка, маршрут: поселок Токи, водитель: Иванов Ф.Ф.');

// Весь документ
$act = new Entities\ActIn();
$act->set('number', '0000003066')
    ->set('date', new DateTime())
    ->set('externalNumber', 'БП-'.rand(100,999)) // номер документа по инфо от поставщика
    ->set('externalDate', '2025-12-25') // дата документа по инфо от поставщика
    ->set('organization', $organization)
    ->set('currency', $currency)
    ->set('responsible', $responsible)
    ->set('amount', 425000)
    ->set('amountIncludesVat', true)
    ->set('counterparty', $counterparty)
    ->set('contract', $contract)
    ->set('services', [$service])
    ->set('taxation', 'ПродажаОблагаетсяНДС')
    ->set('debtRepaymentMethod', 'Автоматически')
    ->set('commentary', 'Сгенерирован');
;

$generator = new DocumentGenerator();

try {
    $xml = $generator->generate($act);
    $generator->saveToFile($xml, './examples/mag-in.xml');

    echo 'Акт успешно сформирован в файл mag-in.xml';
} catch (Exception\UnsupportedDocumentException|Exception\XMLGenerationException $e) {
    echo $e->getMessage();
}