<?php

namespace MaxiStyle\EnterpriseData\Entities;

/**
 * Сущность "Валюта"
 * EnterpriseData: КлючевыеСвойстваВалюта
 */
class Currency
{
    /**
     * @var string Код
     */
    protected string $code = '643';

    /**
     * @var string Наименование
     */
    protected string $name = 'руб.';

    /**
     * @var ?string Ссылка на валюту (UUID)
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
