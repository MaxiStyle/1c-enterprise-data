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
     * @var ?string Дата договора (гггг-мм-дд)
     */
    protected ?string $date = null;

    /**
     * @var ?string Номер договора
     */
    protected ?string $number = null;

    /**
     * @var ?string Вид договора (например СПокупателем)
     */
    protected ?string $contractType = null;

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

    /**
     * @var float|int Курс Взаиморасчетов, который используется для расчета
     * в иностранной валюте
     */
    protected float|int $mutualSettlementRate = 1;

    /**
     * @var int Кратность Взаиморасчетов, сколько единиц одной валюты
     * соответствует одной единице другой (например, 100 иен = 1 рубль)
     */
    protected int $multiplicityMutualSettlements = 1;

    /**
     * @var ?string Ссылка (UUID)
     */
    protected ?string $link = null;

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
