<?php

declare(strict_types = 1);

namespace TryAgainLater\MultiBackedEnum;

use ReflectionEnum;
use ReflectionException;

trait StaticMethods
{
    public static function tryFrom(mixed $rawValue)
    {
        $className = static::class;

        // There is nothing like Attribute::TARGET_ENUM or Attribute::TARGET_ENUM_CASE, so I am not
        // sure what else I was supposed to do...
        try {
            $reflectionEnum = new ReflectionEnum(static::class);
        } catch (ReflectionException) {
            throw new EnumDefinitionError(
                "'$className' is not en enum."
            );
        }

        if (empty($reflectionEnum->getAttributes(MultiBackedEnum::class))) {
            throw new EnumDefinitionError(
                "'$className' is expected to have MultiBackedEnum attribute."
            );
        }
        if ($reflectionEnum->isBacked()) {
            throw new EnumDefinitionError(
                "'$className' is not expected to be a backed enum."
            );
        }

        $reflectionCases = $reflectionEnum->getCases();

        foreach ($reflectionCases as $reflectionCase) {
            if (empty($reflectionCase->getAttributes(Values::class))) {
                assert(false); // TODO: Throw a proper exception
                throw new EnumDefinitionError(
                    "Case '{$reflectionCase->getName()}' on enum '$className' is not annotated" .
                    "with the Values attribute."
                );
            }

            $valuesAttribute = $reflectionCase->getAttributes(Values::class)[0]->newInstance();

            if (empty($valuesAttribute->values())) {
                throw new EnumDefinitionError(
                    "Case '{$reflectionCase->getName()}' on enum '$className' has no values " .
                    "associated with it. (Try passing values to the Values attribute.)"
                );
            }

            foreach ($valuesAttribute->values() as $value) {
                if ($value === $rawValue) {
                    return $reflectionCase->getValue();
                }
            }
        }

        return null;
    }

    public static function from(mixed $rawValue)
    {
        return null;
    }
}
