<?php

namespace MaxiStyle\EnterpriseData\Entities;

use DateTimeInterface;

/**
 * Абстрактный класс Документ
 */
abstract class Document
{
    /**
     * @var DateTimeInterface Дата счёта
     */
    protected ?DateTimeInterface $date = null;

    /**
     * @var string Номер счёта
     */
    protected string $number;

    /**
     * @var Organization КлючевыеСвойства.Организация
     */
    protected ?Organization $organization = null;

    /**
     * @var Currency Валюта счёта
     */
    protected ?Currency $currency = null;

    /**
     * @var Organization Контрагент счёта
     */
    protected ?Organization $counterparty = null;

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
