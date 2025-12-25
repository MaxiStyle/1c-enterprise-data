<?php

namespace MaxiStyle\EnterpriseData\Entities;

use DateTimeInterface;

/**
 * Сущность "Акт покупателю" или "Акт от поставщика"
 * EnterpriseData: Документ.РеализацияТоваровУслуг или Документ.ПоступлениеТоваровУслуг
 */
class Act extends Document
{
    /**
     * @var float Сумма
     */
    protected float $amount;

    /**
     * @var bool СуммаВключаетНДС
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
     * @var array<int, mixed> Товары
     */
    protected array $products = [];

    /**
     * @var array<int, mixed> Услуги
     */
    protected array $services = [];

    /**
     * @var ?Department Подразделение
     */
    protected ?Department $department = null;

    /**
     * @var ?Warehouse Склад
     */
    protected ?Warehouse $warehouse = null;

    /**
     * @var ?string ДоверенностьДата
     */
    protected ?string $proxyDate = null;

    /**
     * @var ?string ДоверенностьНомер
     */
    protected ?string $proxyNumber = null;

    /**
     * @var bool Налогообложение (Облагается НДС или нет)
     */
    protected bool $taxation = true;

    /**
     * @var string СпособПогашенияЗадолженности
     */
    protected string $debtRepaymentMethod = 'Автоматически';

    /**
     * @var ?Order Заказ
     */
    protected ?Order $order = null;

    /**
     * @var ?string Комментарий
     */
    protected ?string $commentary = null;
}
