<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Банковский счет организации"
 * EnterpriseData: БанковскийСчетОрганизации
 */
class BankAccount
{
    /**
     * @var string Номер счета
     */
    private string $accountNumber;

    /**
     * @var Bank Банк
     */
    private Bank $bank;

    /**
     * @var Organization Владелец (организация)
     */
    private Organization $owner;

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
