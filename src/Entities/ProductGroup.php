<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Группа номенклатуры"
 * EnterpriseData: Товары.Строка.ДанныеНоменклатуры.Номенклатура.Группа
 */
class ProductGroup
{
    /**
     * @var string Наименование
     */
    protected string $name;

    /**
     * @var string КодВПрограмме
     */
    protected string $code;

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
