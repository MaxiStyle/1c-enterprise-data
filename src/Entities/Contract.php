<?php

namespace MaxiStyle\EnterpriseData\Entities;

use DateTimeInterface;

/**
 * Сущность "Договор"
 * EnterpriseData: Договор
 */
class Contract
{
    /**
     * @var ?string Наименование (обычно это номер и дата строкой)
     */
    protected ?string $name = null;

    /**
     * @var ?DateTimeInterface Дата договора
     */
    protected ?DateTimeInterface $date = null;

    /**
     * @var ?string Номер договора
     */
    protected ?string $number = null;

    /**
     * @var string Вид договора (в билдерах заполняется автоматически)
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
     * @var string Расчеты в условных единицах (не рубли)
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
