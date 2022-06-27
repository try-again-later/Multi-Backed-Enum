<?php

declare(strict_types = 1);

namespace TryAgainLater\MultiBackedEnum;

trait InstanceMethods
{
    /**
     * Returns the first associated value.
     */
    public function value()
    {
        return $this->allValues()[0];
    }

    public function allValues()
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
                "Case '{$reflectionCase->getName()}' on enum '$class' is not annotated" .
                "with the Values attribute."
            );
        }

        $valuesAttribute = $reflectionCase->getAttributes(Values::class)[0]->newInstance();
        return $valuesAttribute->values();
    }
}
