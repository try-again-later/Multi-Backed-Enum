<?php

declare (strict_types = 1);

namespace TryAgainLater\MultiBackedEnum;

use LogicException;

class EnumDefinitionError extends LogicException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
