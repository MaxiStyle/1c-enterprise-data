<?php

namespace MaxiStyle\EnterpriseData\Entities;

use DateTimeInterface;

/**
 * Сущность "Заказ"
 * EnterpriseData: Заказ
 */
class Order
{
    /**
     * @var ?DateTimeInterface Дата
     */
    protected ?DateTimeInterface $date = null;

    /**
     * @var string Номер
     */
    protected string $number;

    /**
     * @var ?Organization Организация
     */
    protected ?Organization $organization = null;

    /**
     * @var ?string Ссылка на Склад (UUID)
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
