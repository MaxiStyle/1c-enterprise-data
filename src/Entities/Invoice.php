<?php

namespace MaxiStyle\EnterpriseData\Entities;

use DateTimeInterface;

/**
 * Сущность "Счёт покупателю" или "Счёт от поставщика"
 * EnterpriseData: Документ.ЗаказКлиента или Документ.ЗаказПоставщику
 */
class Invoice extends Document
{
    /**
     * @var float Сумма
     */
    protected float $amount;

    /**
     * @var string СуммаВключаетНДС
     */
    protected bool $amountIncludesVat = true;

    /**
     * @var ?Contract Данные взаиморасчетов
     */
    protected ?Contract $contract = null;

    /**
     * @var ?BankAccount Банковский счет организации
     */
    protected ?BankAccount $bankAccount = null;

    /**
     * @var array Товары
     */
    protected array $products = [];

    /**
     * @var array Услуги
     */
    protected array $services = [];

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
