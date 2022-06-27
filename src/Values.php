<?php

declare (strict_types = 1);

namespace TryAgainLater\MultiBackedEnum;

use Attribute;

#[Attribute]
class Values
{
    private array $values;

    public function __construct(mixed ...$values)
    {
        $this->values = $values;
    }

    public function values(): array
    {
        return $this->values;
    }
}
