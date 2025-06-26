<?php

declare (strict_types = 1);

namespace TryAgainLater\MultiBackedEnum;

use Attribute;
use ReflectionEnum;
use ReflectionException;
use UnitEnum;

#[Attribute]
class MultiBackedEnum
{
    /**
     * @template T of UnitEnum
     * @param class-string<T> $class
     *
     * @return ReflectionEnum<T>
     */
    public static function getReflectionEnum(string $class): ReflectionEnum
    {
        // There is nothing like Attribute::TARGET_ENUM or Attribute::TARGET_ENUM_CASE, so I am not
        // sure what else I was supposed to do...
        try {
            $reflectionEnum = new ReflectionEnum($class);
        } catch (ReflectionException) {
            throw new EnumDefinitionError(
                "'$class' is not en enum."
            );
        }

        if (empty($reflectionEnum->getAttributes(MultiBackedEnum::class))) {
            throw new EnumDefinitionError(
                "'$class' is expected to have MultiBackedEnum attribute."
            );
        }
        if ($reflectionEnum->isBacked()) {
            throw new EnumDefinitionError(
                "'$class' is not expected to be a backed enum."
            );
        }

        return $reflectionEnum;
    }

    /**
     * @template T of UnitEnum
     * @param class-string<T> $class
     *
     * @return array<int|string, T>
     */
    public static function getValuesMapping(string $class): array
    {
        $reflectionEnum = self::getReflectionEnum($class);
        $reflectionCases = $reflectionEnum->getCases();
        $valuesMapping = [];

        foreach ($reflectionCases as $reflectionCase) {
            if (empty($reflectionCase->getAttributes(Values::class))) {
                throw new EnumDefinitionError(
                    "Case '{$reflectionCase->getName()}' on enum '$class' is not annotated " .
                    "with the Values attribute."
                );
            }

            $valuesAttribute = $reflectionCase->getAttributes(Values::class)[0]->newInstance();

            if (empty($valuesAttribute->values())) {
                throw new EnumDefinitionError(
                    "Case '{$reflectionCase->getName()}' on enum '$class' has no values " .
                    "associated with it. (Try passing values to the Values attribute.)"
                );
            }

            /** @var T */
            $enumCase = $reflectionCase->getValue();
            foreach ($valuesAttribute->values() as $value) {
                $valuesMapping[$value] = $enumCase;
            }
        }

        return $valuesMapping;
    }
}
