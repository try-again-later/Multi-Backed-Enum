<?php

declare(strict_types = 1);

namespace TryAgainLater\MultiBackedEnum;

trait InstanceMethods
{
    /**
     * Returns the first associated value.
     */
    public function value(): int|string
    {
        return $this->allValues()[0];
    }

    /**
     * @return list<int|string>
     */
    public function allValues(): array
    {
        $reflectionEnum = MultiBackedEnum::getReflectionEnum(self::class);
        $foundReflectionCase = null;

        foreach ($reflectionEnum->getCases() as $reflectionCase)
        {
            if ($this === $reflectionCase->getValue()) {
                $foundReflectionCase = $reflectionCase;
                break;
            }
        }

        assert(isset($foundReflectionCase));

        if (empty($foundReflectionCase->getAttributes(Values::class))) {
            $class = self::class;
            throw new EnumDefinitionError(
                "Case '{$foundReflectionCase->getName()}' on enum '$class' is not annotated " .
                "with the Values attribute."
            );
        }

        $valuesAttribute = $foundReflectionCase->getAttributes(Values::class)[0]->newInstance();
        return $valuesAttribute->values();
    }
}
