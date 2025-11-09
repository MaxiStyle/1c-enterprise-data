<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Договор"
 * EnterpriseData: Договор
 */
class Contract
{
    /**
     * @var string Наименование
     */
    protected ?string $name = null;

    /**
     * @var string Вид договора
     */
    protected string $contractType = 'СПокупателем';

    /**
     * @var Organization Организация
     */
    protected Organization $organization;

    /**
     * @var Organization Контрагент
     */
    protected Organization $counterparty;

    /**
     * @var Currency Валюта взаиморасчетов
     */
    protected Currency $currency;

    /**
     * @var bool Расчеты в условных единицах
     */
    protected string $calculationsInConditionalUnits = 'false';

    public function get(string $name): mixed
    {
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("Property {$name} does not exist");
        }
        return $this->$name;
    }

    public function set(string $name, mixed $value): self
    {
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("Property {$name} does not exist");
        }
        $this->$name = $value;
        return $this;
    }
}
