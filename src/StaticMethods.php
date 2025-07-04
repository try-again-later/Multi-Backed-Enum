<?php

declare(strict_types = 1);

namespace TryAgainLater\MultiBackedEnum;

use ValueError;

trait StaticMethods
{
    public static function tryFrom(int|string $rawValue): ?self
    {
        $valuesMapping = MultiBackedEnum::getValuesMapping(self::class);

        if (!isset($valuesMapping[$rawValue])) {
            return null;
        }

        return $valuesMapping[$rawValue];
    }

    public static function from(int|string $rawValue): self
    {
        $enum = self::tryFrom($rawValue);
        if (!isset($enum)) {
            throw new ValueError("Cannot parse an enum from value '$rawValue'.");
        }
        return $enum;
    }
}
