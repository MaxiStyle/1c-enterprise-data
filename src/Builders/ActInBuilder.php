<?php

namespace MaxiStyle\EnterpriseData\Builders;

use DOMException;
use MaxiStyle\EnterpriseData\Builders\DocumentBuilderInterface;
use MaxiStyle\EnterpriseData\Entities\ActIn;
use DOMDocument;
use DOMElement;

/**
 * Конструктор "Акт от поставщика" или входящий акт
 * EnterpriseData: Документ.ПоступлениеТоваровУслуг
 */

class ActInBuilder extends DocumentBuilder implements DocumentBuilderInterface
{
    /**
     * @throws DOMException
     */
    public function build(DOMDocument $dom, DOMElement $parent, object $act): void
    {
        if (!$act instanceof ActIn) {
            throw new \InvalidArgumentException('Документ должен быть экземпляром ActIn');
        }

        $document = $dom->createElement('Документ.ПоступлениеТоваровУслуг');

        // КлючевыеСвойства
        $keyProps = $dom->createElement('КлючевыеСвойства');
        $keyProps->appendChild($dom->createElement('Дата', $act->get('date')->format('Y-m-d\TH:i:s')));
        $keyProps->appendChild($dom->createElement('Номер', $act->get('number')));

        // Организация
        $organization = $dom->createElement('Организация');
        $org = $act->get('organization');
        $this->append($dom, $organization, 'Ссылка', $org->get('link'));
        $this->append($dom, $organization, 'Наименование', $org->get('name'));
        $this->append($dom, $organization, 'НаименованиеСокращенное', $org->get('shortName'));
        $this->append($dom, $organization, 'НаименованиеПолное', $org->get('fullName'));
        $this->append($dom, $organization, 'ИНН', $org->get('inn'));
        $this->append($dom, $organization, 'КПП', $org->get('kpp'));
        $this->append($dom, $organization, 'ЮридическоеФизическоеЛицо', $org->get('type'));
        $keyProps->appendChild($organization);

        $document->appendChild($keyProps);

        // ДанныеВходящегоДокумента
        if ($act->get('externalNumber') !== null || $act->get('externalDate') !== null) {
            $external = $dom->createElement('ДанныеВходящегоДокумента');
            $this->append($dom, $external, 'НомерВходящегоДокумента', $act->get('externalNumber'));
            $this->append($dom, $external, 'ДатаВходящегоДокумента', $act->get('externalDate'));
            $document->appendChild($external);
        }

        // Товары
        if (!empty($act->get('products'))) {
            $products = $dom->createElement('Товары');

            foreach ($act->get('products') as $product) {
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
                $this->append($dom, $group, 'Ссылка', $groupEntity->get('link'));
                $this->append($dom, $group, 'Наименование', $groupEntity->get('name'));
                $this->append($dom, $group, 'КодВПрограмме', $groupEntity->get('code'));
                $nomenclature->appendChild($group);

                $productData->appendChild($nomenclature);
                $line->appendChild($productData);

                // ЕдиницаИзмерения
                $unit = $dom->createElement('ЕдиницаИзмерения');
                $unitEntity = $product->get('unitOfMeasure');
                $this->append($dom, $unit, 'Ссылка', $unitEntity->get('link'));
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
        if (!empty($act->get('services'))) {
            $services = $dom->createElement('Услуги');

            foreach ($act->get('services') as $service) {
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
                
                // ЭтоДопРасходы - по умолчанию false
                $this->append($dom, $line, 'ЭтоДопРасходы', 'false');

                $services->appendChild($line);
            }
            $document->appendChild($services);
        }


        // Ответственный
        if ($act->get('responsible') !== null) {
            $responsible = $dom->createElement('Ответственный');
            $res = $act->get('responsible');
            $this->append($dom, $responsible, 'Наименование', $res->get('name'));
            $document->appendChild($responsible);
        }

        // Валюта
        $currency = $dom->createElement('Валюта');
        $cur = $act->get('currency');
        $this->append($dom, $currency, 'Ссылка', $cur->get('link'));
        $currency->appendChild($dom->createElement('Код', $cur->get('code')));
        $currency->appendChild($dom->createElement('Наименование', $cur->get('name')));
        $document->appendChild($currency);

        // ВидОперации
        $this->append($dom, $document, 'ВидОперации', $act->get('type'));

        // Сумма
        $document->appendChild($dom->createElement('Сумма', $act->get('amount')));
        // СуммаВключаетНДС
        $this->append($dom, $document, 'СуммаВключаетНДС', $act->get('amountIncludesVat') ? 'true' : 'false');

        // Контрагент
        $counterparty = $dom->createElement('Контрагент');
        $org = $act->get('counterparty');
        $this->append($dom, $counterparty, 'Ссылка', $org->get('link'));
        $this->append($dom, $counterparty, 'Наименование', $org->get('name'));
        $this->append($dom, $counterparty, 'НаименованиеПолное', $org->get('fullName'));
        $this->append($dom, $counterparty, 'ИНН', $org->get('inn'));
        $this->append($dom, $counterparty, 'КПП', $org->get('kpp'));
        $this->append($dom, $counterparty, 'ЮридическоеФизическоеЛицо', $org->get('type'));

        // СтранаРегистрации (опционально)
        if ($org->get('countryRegistrationCode') !== null) {
            $country = $dom->createElement('СтранаРегистрации');
            $this->append($dom, $country, 'Код', $org->get('countryRegistrationCode'));
            $this->append($dom, $country, 'Наименование', $org->get('countryRegistrationName'));
            $counterparty->appendChild($country);
        }
        $document->appendChild($counterparty);

        // ДанныеВзаиморасчетов
        if ($act->get('contract') !== null) {
            $paymentData = $dom->createElement('ДанныеВзаиморасчетов');

            // Договор
            $contract = $dom->createElement('Договор');
            $ctr = $act->get('contract');
            $this->append($dom, $contract, 'Ссылка', $ctr->get('link'));
            $this->append($dom, $contract, 'ВидДоговора', $ctr->get('contractType'));

            // Организация в договоре
            $contractOrg = $dom->createElement('Организация');
            $org = $act->get('organization');
            $this->append($dom, $contractOrg, 'Ссылка', $org->get('link'));
            $this->append($dom, $contractOrg, 'Наименование', $org->get('name'));
            $this->append($dom, $contractOrg, 'НаименованиеСокращенное', $org->get('shortName'));
            $this->append($dom, $contractOrg, 'НаименованиеПолное', $org->get('fullName'));
            $this->append($dom, $contractOrg, 'ИНН', $org->get('inn'));
            $this->append($dom, $contractOrg, 'КПП', $org->get('kpp'));
            $this->append($dom, $contractOrg, 'ЮридическоеФизическоеЛицо', $org->get('type'));
            $contract->appendChild($contractOrg);

            // Контрагент в договоре
            $contractCounterparty = $dom->createElement('Контрагент');
            $org = $act->get('counterparty');
            $this->append($dom, $contractCounterparty, 'Ссылка', $org->get('link'));
            $this->append($dom, $contractCounterparty, 'Наименование', $org->get('name'));
            $this->append($dom, $contractCounterparty, 'НаименованиеПолное', $org->get('fullName'));
            $this->append($dom, $contractCounterparty, 'ИНН', $org->get('inn'));
            $this->append($dom, $contractCounterparty, 'КПП', $org->get('kpp'));
            $this->append($dom, $contractCounterparty, 'ЮридическоеФизическоеЛицо', $org->get('type'));
            
            // СтранаРегистрации в договоре
            if ($org->get('countryRegistrationCode') !== null) {
                $country = $dom->createElement('СтранаРегистрации');
                $this->append($dom, $country, 'Код', $org->get('countryRegistrationCode'));
                $this->append($dom, $country, 'Наименование', $org->get('countryRegistrationName'));
                $contractCounterparty->appendChild($country);
            }
            
            $contract->appendChild($contractCounterparty);

            // ВалютаВзаиморасчетов
            $contractCurrency = $dom->createElement('ВалютаВзаиморасчетов');
            $cur = $act->get('currency');
            $this->append($dom, $contractCurrency, 'Ссылка', $cur->get('link'));
            $this->append($dom, $contractCurrency, 'Код', $cur->get('code'));
            $this->append($dom, $contractCurrency, 'Наименование', $cur->get('name'));
            $contract->appendChild($contractCurrency);

            // Свойства договора
            $this->append($dom, $contract, 'РасчетыВУсловныхЕдиницах', $ctr->get('calculationsInConditionalUnits'));
            $this->append($dom, $contract, 'Наименование', $ctr->get('name'));
            $this->append($dom, $contract, 'Дата', $ctr->get('date'));
            $this->append($dom, $contract, 'Номер', $ctr->get('number'));
            $paymentData->appendChild($contract);

            // ВалютаВзаиморасчетов (на уровне ДанныеВзаиморасчетов)
            $paymentCurrency = $dom->createElement('ВалютаВзаиморасчетов');
            $this->append($dom, $paymentCurrency, 'Ссылка', $cur->get('link'));
            $this->append($dom, $paymentCurrency, 'Код', $cur->get('code'));
            $this->append($dom, $paymentCurrency, 'Наименование', $cur->get('name'));
            $paymentData->appendChild($paymentCurrency);

            $this->append($dom, $paymentData, 'КурсВзаиморасчетов', '1');
            $this->append($dom, $paymentData, 'КратностьВзаиморасчетов', '1');
            $this->append($dom, $paymentData, 'РасчетыВУсловныхЕдиницах', $ctr->get('calculationsInConditionalUnits'));

            $document->appendChild($paymentData);
        }

        $this->append($dom, $document, 'Комментарий', $act->get('commentary'));

        // Налогообложение
        if ($act->get('taxation')) {
            $this->append($dom, $document, 'Налогообложение', 'ПродажаОблагаетсяНДС');
        }

        // СпособПогашенияЗадолженности
        if ($act->get('debtRepaymentMethod') !== null) {
            $this->append($dom, $document, 'СпособПогашенияЗадолженности', $act->get('debtRepaymentMethod'));
        }

        $parent->appendChild($document);
    }
}
