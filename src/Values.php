<?php

declare (strict_types = 1);

namespace TryAgainLater\MultiBackedEnum;

use Attribute;

#[Attribute]
class Values
{
    /** @var list<int|string> */
    private array $values;

    /**
     * @param int|string ...$values
     */
    public function __construct(int|string ...$values)
    {
        $this->values = array_values($values);
    }

    /**
     * @return list<int|string>
     */
    public function values(): array
    {
        return $this->values;
    }
}
