<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Банк"
 * EnterpriseData: Банк
 */
class Bank
{
    /**
     * @var string БИК
     */
    protected string $bik;

    /**
     * @var string КоррСчет
     */
    protected string $corAccount;

    /**
     * @var string Наименование
     */
    protected string $name;

    /**
     * @var string СВИФТБИК
     */
    protected ?string $swift = null;

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
