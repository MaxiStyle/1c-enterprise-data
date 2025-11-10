<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Услуга в счете"
 * EnterpriseData: Строка (в узле Услуги)
 */
class Service
{
    /**
     * @var float Количество
     */
    protected float $quantity;

    /**
     * @var float Сумма
     */
    protected float $amount;

    /**
     * @var float Цена
     */
    protected float $price;

    /**
     * @var string СтавкаНДС
     */
    protected string $vatRate = 'НДС20';

    /**
     * @var float СуммаНДС
     */
    protected float $vatAmount;

    /**
     * @var string Содержание (полное описание услуги)
     */
    protected string $description;

    /**
     * @var ?Nomenclature Данные номенклатуры
     */
    protected ?Nomenclature $nomenclature = null;

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
