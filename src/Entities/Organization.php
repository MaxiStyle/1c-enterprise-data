<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Организация"
 * EnterpriseData: КлючевыеСвойства.Организация
 */
class Organization
{
    /**
     * @var ?string Наименование
     */
    protected ?string $name = null;

    /**
     * @var ?string Наименование Сокращенное
     */
    protected ?string $shortName = null;

    /**
     * @var ?string Наименование Полное
     */
    protected ?string $fullName = null;

    /**
     * @var string ИНН
     */
    protected string $inn;

    /**
     * @var ?string КПП
     */
    protected ?string $kpp = null;

    /**
     * @var string Юридическое или Физическое Лицо (обязательно)
     */
    protected string $type = 'ЮридическоеЛицо';

    /**
     * @var ?string Страна Регистрации Код
     */
    protected ?string $countryRegistrationCode = null;

    /**
     * @var ?string Страна Регистрации Наименование
     */
    protected ?string $countryRegistrationName = null;

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
