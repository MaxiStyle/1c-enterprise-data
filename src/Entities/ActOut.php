<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Акт покупателю"
 * EnterpriseData: Документ.РеализацияТоваровУслуг
 */
class ActOut extends Act
{
    /**
     * @var string ВидОперации
     */
    protected string $type = 'РеализацияКлиенту';
}
