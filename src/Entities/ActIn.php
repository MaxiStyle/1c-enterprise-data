<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Акт от поставщика"
 * EnterpriseData: Документ.ПоступлениеТоваровУслуг
 */
class ActIn extends Act
{
    /**
     * @var string ВидОперации
     */
    protected string $type = 'ПокупкаУПоставщика';

    /**
     * @var ?string НомерВходящегоДокумента
     */
    protected ?string $externalNumber = null;

    /**
     * @var ?string ДатаВходящегоДокумента (ГГГГ-ММ-ДД)
     */
    protected ?string $externalDate = null;
}
