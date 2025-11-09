<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Организация"
 * EnterpriseData: КлючевыеСвойства.Организация
 */
class Organization
{
    /**
     * @var string Наименование
     */
    private ?string $name = null;

    /**
     * @var string Наименование Сокращенное
     */
    private ?string $shortName = null;

    /**
     * @var string Наименование Полное
     */
    private ?string $fullName = null;

    /**
     * @var string ИНН
     */
    private string $inn;

    /**
     * @var string КПП
     */
    private ?string $kpp = null;

    /**
     * @var string Юридическое или Физическое Лицо (обязательно)
     */
    private string $type = 'ЮридическоеЛицо';

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
