<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Номенклатура"
 * EnterpriseData: Номенклатура
 */
class Nomenclature
{
    /**
     * @var ?string НаименованиеПолное
     */
    protected ?string $fullName = null;

    /**
     * @var ?string КодВПрограмме
     */
    protected ?string $code = null;

    /**
     * @var ?string Ссылка
     */
    protected ?string $link = null;

    /**
     * @var ?string Наименование
     */
    protected ?string $name = null;

    /**
     * @var ?ProductGroup Группа
     */
    protected ?ProductGroup $group = null;

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
