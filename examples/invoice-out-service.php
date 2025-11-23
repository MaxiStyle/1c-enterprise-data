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
$counterparty->set('name', 'Этнопарк Перун')
    ->set('shortName', 'ООО "Этнопарк "Перун"')
    ->set('fullName', 'ООО "Этнопарк "Перун"')
    ->set('inn', '5099891610')
    ->set('kpp', '509901001')
    ->set('countryRegistrationCode', '643')
    ->set('countryRegistrationName', 'РОССИЯ')
;

// Валюта
$currency = new Entities\Currency();

// Ответственный
$responsible = new Entities\Responsible();
$responsible->set('name', 'Иванов Иван Иванович');


// ДанныеВзаиморасчетов
// Договор
$contract = new Entities\Contract();
$contract->set('name', 'С покупателем - руб.')
    ->set('organization', $organization)
    ->set('counterparty', $counterparty)
    ->set('currency', $currency)
    ->set('calculationsInConditionalUnits', 'false')
    ->set('date', '2022-01-31')
    ->set('number', 'У/0008/БМ')
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



// Услуги
$services = [];

// Первая услуга
// Номенклатура первой услуги
$services[1]['nomenclature'] = new Entities\Nomenclature();
$services[1]['nomenclature']->set('name', 'Транспортно-экспедиционные услуги')
    ->set('fullName', 'Транспортно-экспедиционные услуги');

$services[1]['service'] = new Entities\Service();
$services[1]['service']->set('nomenclature', $services[1]['nomenclature'])
    ->set('description', 'Транспортно-экспедиционные услуги, Маршрут: г Благовещенск - г Хабаровск, авт.: Freightliner fld 112, г/н: В703РС75, Перевозка: 16') // описание
    ->set('quantity', 1) // количество
    ->set('amount', 228000) // сумма (цена*количество)
    ->set('price', 228000) // цена за 1 единицу
    ->set('vatRate', 'НДС20') // налог
    ->set('vatAmount', 38000) // сумма НДС
;


// Весь документ
$invoice = new Entities\InvoiceOut();
$invoice->set('number', '0000-000'.rand(100, 999))
    ->set('date', new DateTime())
    ->set('organization', $organization)
    ->set('currency', $currency)
    ->set('responsible', $responsible)
    ->set('amount', 228000)
    ->set('amountIncludesVat', 'true')
    ->set('counterparty', $counterparty)
    ->set('contract', $contract)
    ->set('bankAccount', $bankAccount)
    ->set('services', array_column($services, 'service'))
;

$generator = new DocumentGenerator();

try {
    $xml = $generator->generate($invoice);
    $generator->saveToFile($xml, './examples/invoice-out-service.xml');

    echo 'Счёт успешно сформирован';
} catch (Exception\UnsupportedDocumentException|Exception\XMLGenerationException $e) {
    echo $e->getMessage();
}
