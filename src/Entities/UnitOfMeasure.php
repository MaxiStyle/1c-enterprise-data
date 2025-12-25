<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Единица измерения"
 * EnterpriseData: ЕдиницаИзмерения
 */
class UnitOfMeasure
{
    /**
     * @var ?string Код
     */
    protected ?string $code = null;

    /**
     * @var ?string Наименование
     */
    protected ?string $name = null;

    /**
     * @var ?string Ссылка на единицу измерения (UUID)
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
