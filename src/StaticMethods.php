<?php

declare(strict_types = 1);

namespace TryAgainLater\MultiBackedEnum;

use ValueError;

trait StaticMethods
{
    public static function tryFrom(mixed $rawValue)
    {
        $valuesMapping = MultiBackedEnum::getValuesMapping(self::class);

        if (!isset($valuesMapping[$rawValue])) {
            return null;
        }

        return $valuesMapping[$rawValue];
    }

    public static function from(mixed $rawValue)
    {
        $enum = self::tryFrom($rawValue);
        if (!isset($enum)) {
            throw new ValueError("Cannot parse an enum from value '$rawValue'.");
        }
        return $enum;
    }
}
