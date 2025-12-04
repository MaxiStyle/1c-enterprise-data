<?php

namespace MaxiStyle\EnterpriseData\Builders;

use DOMException;
use MaxiStyle\EnterpriseData\Builders\DocumentBuilderInterface;
use MaxiStyle\EnterpriseData\Entities\Invoice;
use DOMDocument;
use DOMElement;

/**
 * Конструктор "Счёт от поставщика" или входящий счёт
 * EnterpriseData: Документ.ЗаказПоставщику
 */

class InvoiceInBuilder extends DocumentBuilder implements DocumentBuilderInterface
{
    /**
     * @throws DOMException
     */
    public function build(DOMDocument $dom, DOMElement $parent, object $invoice): void
    {
        if (!$invoice instanceof Invoice) {
            throw new \InvalidArgumentException('Документ должен быть экземпляром Invoice');
        }

        $document = $dom->createElement('Документ.ЗаказПоставщику');

        // КлючевыеСвойства
        $keyProps = $dom->createElement('КлючевыеСвойства');
        $keyProps->appendChild($dom->createElement('Дата', $invoice->get('date')->format('Y-m-d\TH:i:s')));
        $keyProps->appendChild($dom->createElement('Номер', $invoice->get('number')));

        // Организация
        $organization = $dom->createElement('Организация');
        $org = $invoice->get('organization');
        $this->append($dom, $organization, 'Наименование', $org->get('name'));
        $this->append($dom, $organization, 'НаименованиеСокращенное', $org->get('shortName'));
        $this->append($dom, $organization, 'НаименованиеПолное', $org->get('fullName'));
        $this->append($dom, $organization, 'ИНН', $org->get('inn'));
        $this->append($dom, $organization, 'КПП', $org->get('kpp'));
        $this->append($dom, $organization, 'ЮридическоеФизическоеЛицо', $org->get('type'));
        $keyProps->appendChild($organization);

        $document->appendChild($keyProps);

        // Ответственный
        if ($invoice->get('responsible') !== null) {
            $responsible = $dom->createElement('Ответственный');
            $res = $invoice->get('responsible');
            $this->append($dom, $responsible, 'Наименование', $res->get('name'));
            $document->appendChild($responsible);
        }

        // Валюта
        $currency = $dom->createElement('Валюта');
        $cur = $invoice->get('currency');
        $currency->appendChild($dom->createElement('Код', $cur->get('code')));
        $currency->appendChild($dom->createElement('Наименование', $cur->get('name')));
        $document->appendChild($currency);

        // Сумма
        $document->appendChild($dom->createElement('Сумма', $invoice->get('amount')));

        // Контрагент
        $counterparty = $dom->createElement('Контрагент');
        $org = $invoice->get('counterparty');
        $this->append($dom, $counterparty, 'Наименование', $org->get('name'));
        $this->append($dom, $counterparty, 'НаименованиеСокращенное', $org->get('shortName'));
        $this->append($dom, $counterparty, 'НаименованиеПолное', $org->get('fullName'));
        $this->append($dom, $counterparty, 'ИНН', $org->get('inn'));
        $this->append($dom, $counterparty, 'КПП', $org->get('kpp'));
        $this->append($dom, $counterparty, 'ЮридическоеФизическоеЛицо', $org->get('type'));
        if ($org->get('countryRegistrationCode') !== null || $org->get('countryRegistrationName') !== null) {
            $countryRegistration = $dom->createElement('СтранаРегистрации');
            $this->append($dom, $countryRegistration, 'Код', $org->get('countryRegistrationCode'));
            $this->append($dom, $countryRegistration, 'Наименование', $org->get('countryRegistrationName'));
            $counterparty->appendChild($countryRegistration);
        }
        $document->appendChild($counterparty);

        // ДанныеВзаиморасчетов
        if ($invoice->get('contract') !== null) {
            $paymentData = $dom->createElement('ДанныеВзаиморасчетов');

            // Договор
            $contract = $dom->createElement('Договор');
            $ctr = $invoice->get('contract');
            $contract->appendChild($dom->createElement('ВидДоговора', 'СПоставщиком'));

            // Организация в договоре
            $contractOrg = $dom->createElement('Организация');
            $org = $invoice->get('organization');
            $this->append($dom, $contractOrg, 'Наименование', $org->get('name'));
            $this->append($dom, $contractOrg, 'НаименованиеСокращенное', $org->get('shortName'));
            $this->append($dom, $contractOrg, 'НаименованиеПолное', $org->get('fullName'));
            $this->append($dom, $contractOrg, 'ИНН', $org->get('inn'));
            $this->append($dom, $contractOrg, 'КПП', $org->get('kpp'));
            $this->append($dom, $contractOrg, 'ЮридическоеФизическоеЛицо', $org->get('type'));
            $contract->appendChild($contractOrg);

            // Контрагент в договоре
            $contractCounterparty = $dom->createElement('Контрагент');
            $org = $invoice->get('counterparty');
            $this->append($dom, $contractCounterparty, 'Наименование', $org->get('name'));
            $this->append($dom, $contractCounterparty, 'НаименованиеПолное', $org->get('fullName'));
            $this->append($dom, $contractCounterparty, 'ИНН', $org->get('inn'));
            $this->append($dom, $contractCounterparty, 'КПП', $org->get('kpp'));
            $this->append($dom, $contractCounterparty, 'ЮридическоеФизическоеЛицо', $org->get('type'));
            $contract->appendChild($contractCounterparty);

            // ВалютаВзаиморасчетов
            $contractCurrency = $dom->createElement('ВалютаВзаиморасчетов');
            $cur = $invoice->get('currency');
            $this->append($dom, $contractCurrency, 'Код', $cur->get('code'));
            $this->append($dom, $contractCurrency, 'Наименование', $cur->get('name'));
            $contract->appendChild($contractCurrency);

            // Свойства договора
            $this->append($dom, $contract, 'РасчетыВУсловныхЕдиницах', $ctr->get('calculationsInConditionalUnits'));
            $this->append($dom, $contract, 'Наименование', $ctr->get('name'));
            $this->append($dom, $contract, 'Дата', $ctr->get('date'));
            $this->append($dom, $contract, 'Номер', $ctr->get('number'));

            $paymentData->appendChild($contract);

            // ВалютаВзаиморасчетов (дублирование на уровне ДанныеВзаиморасчетов)
            $paymentCurrency = $dom->createElement('ВалютаВзаиморасчетов');
            $this->append($dom, $paymentCurrency, 'Код', $cur->get('code'));
            $this->append($dom, $paymentCurrency, 'Наименование', $cur->get('name'));
            $paymentData->appendChild($paymentCurrency);

            $this->append($dom, $paymentData, 'КурсВзаиморасчетов', $ctr->get('mutualSettlementRate'));
            $this->append($dom, $paymentData, 'КратностьВзаиморасчетов', $ctr->get('multiplicityMutualSettlements'));
            $this->append($dom, $paymentData, 'РасчетыВУсловныхЕдиницах', $ctr->get('calculationsInConditionalUnits'));

            $document->appendChild($paymentData);
        }

        // СуммаВключаетНДС
        if ($invoice->get('amountIncludesVat') === true) {
            $amountIncludesVat = $dom->createElement('СуммаВключаетНДС', 'true');
            $document->appendChild($amountIncludesVat);
        }

        // БанковскийСчетОрганизации
        if ($invoice->get('bankAccount') !== null) {
            $bankAccount = $dom->createElement('БанковскийСчетОрганизации');
            $bankAccount->appendChild(
                $dom->createElement(
                    'НомерСчета',
                    $invoice->get('bankAccount')->get('accountNumber')
                )
            );

            // Банк
            $bank = $dom->createElement('Банк');
            $bankEntity = $invoice->get('bankAccount')->get('bank');
            $this->append($dom, $bank, 'БИК', $bankEntity->get('bik'));
            $this->append($dom, $bank, 'КоррСчет', $bankEntity->get('corAccount'));
            $this->append($dom, $bank, 'Наименование', $bankEntity->get('name'));
            $this->append($dom, $bank, 'СВИФТБИК', $bankEntity->get('swift'));
            $bankAccount->appendChild($bank);

            // Владелец
            $owner = $dom->createElement('Владелец');
            $ownerRef = $dom->createElement('ОрганизацииСсылка');
            $org = $invoice->get('organization');
            $this->append($dom, $ownerRef, 'Наименование', $org->get('name'));
            $this->append($dom, $ownerRef, 'НаименованиеСокращенное', $org->get('shortName'));
            $this->append($dom, $ownerRef, 'НаименованиеПолное', $org->get('fullName'));
            $this->append($dom, $ownerRef, 'ИНН', $org->get('inn'));
            $this->append($dom, $ownerRef, 'КПП', $org->get('kpp'));
            $this->append($dom, $ownerRef, 'ЮридическоеФизическоеЛицо', $org->get('type'));
            $owner->appendChild($ownerRef);
            $bankAccount->appendChild($owner);

            $document->appendChild($bankAccount);
        }

        // Товары
        if (!empty($invoice->get('products'))) {
            $products = $dom->createElement('Товары');

            foreach ($invoice->get('products') as $product) {
                $line = $dom->createElement('Строка');

                // ДанныеНоменклатуры
                $productData = $dom->createElement('ДанныеНоменклатуры');
                $nomenclature = $dom->createElement('Номенклатура');

                $nomenclatureEntity = $product->get('nomenclature');
                $this->append($dom, $nomenclature, 'Ссылка', $nomenclatureEntity->get('link'));
                $this->append($dom, $nomenclature, 'НаименованиеПолное', $nomenclatureEntity->get('fullName'));
                $this->append($dom, $nomenclature, 'КодВПрограмме', $nomenclatureEntity->get('code'));
                $this->append($dom, $nomenclature, 'Наименование', $nomenclatureEntity->get('name'));

                // Группа
                $group = $dom->createElement('Группа');
                $groupEntity = $nomenclatureEntity->get('group');
                $this->append($dom, $group, 'Наименование', $groupEntity->get('name'));
                $this->append($dom, $group, 'КодВПрограмме', $groupEntity->get('code'));
                $nomenclature->appendChild($group);

                $productData->appendChild($nomenclature);
                $line->appendChild($productData);

                // ЕдиницаИзмерения
                $unit = $dom->createElement('ЕдиницаИзмерения');
                $unitEntity = $product->get('unitOfMeasure');
                $this->append($dom, $unit, 'Код', $unitEntity->get('code'));
                $this->append($dom, $unit, 'Наименование', $unitEntity->get('name'));
                $line->appendChild($unit);

                // Остальные поля
                $this->append($dom, $line, 'Количество', $product->get('quantity'));
                $this->append($dom, $line, 'Сумма', $product->get('amount'));
                $this->append($dom, $line, 'Цена', $product->get('price'));
                $this->append($dom, $line, 'СтавкаНДС', $product->get('vatRate'));
                $this->append($dom, $line, 'СуммаНДС', $product->get('vatAmount'));
                $this->append($dom, $line, 'ТипЗапасов', $product->get('stockType'));

                $products->appendChild($line);
            }

            $document->appendChild($products);
        }

        // Услуги
        if (!empty($invoice->get('services'))) {
            $services = $dom->createElement('Услуги');

            foreach ($invoice->get('services') as $service) {
                $line = $dom->createElement('Строка');

                // Номенклатура
                $nomenclature = $dom->createElement('Номенклатура');
                $nomenclatureEntity = $service->get('nomenclature');
                $this->append($dom, $nomenclature, 'Ссылка', $nomenclatureEntity->get('link'));
                $this->append($dom, $nomenclature, 'НаименованиеПолное', $nomenclatureEntity->get('fullName'));
                $this->append($dom, $nomenclature, 'КодВПрограмме', $nomenclatureEntity->get('code'));
                $this->append($dom, $nomenclature, 'Наименование', $nomenclatureEntity->get('name'));
                $line->appendChild($nomenclature);

                // Остальные поля
                $this->append($dom, $line, 'Количество', $service->get('quantity'));
                $this->append($dom, $line, 'Сумма', $service->get('amount'));
                $this->append($dom, $line, 'Цена', $service->get('price'));
                $this->append($dom, $line, 'СтавкаНДС', $service->get('vatRate'));
                $this->append($dom, $line, 'СуммаНДС', $service->get('vatAmount'));
                $this->append($dom, $line, 'Содержание', $service->get('description'));

                $services->appendChild($line);
            }
            $document->appendChild($services);
        }

        $parent->appendChild($document);
    }
}
