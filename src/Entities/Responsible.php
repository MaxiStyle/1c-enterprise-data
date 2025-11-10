<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Ответственный"
 */
class Responsible
{
    /**
     * @var ?string Наименование
     */
    protected ?string $name = null;

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
