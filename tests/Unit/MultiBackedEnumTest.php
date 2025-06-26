<?php

declare(strict_types = 1);

use TryAgainLater\MultiBackedEnum\{MultiBackedEnum, Values, MakeMultiBacked};

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

#[MultiBackedEnum]
enum StringsBackedEnum
{
    #[Values('foo')]
    case Foo;

    #[Values('bar', 'bar alternative')]
    case Bar;

    #[Values('baz', 'baz alternative')]
    case Baz;

    use MakeMultiBacked;
}

class MultiBackedEnumTest extends TestCase
{
    #[Test]
    public function tryFromReturnsNull_givenNonExistentValue(): void
    {
        $enum = StringsBackedEnum::tryFrom('non existent value');

        $this->assertNull($enum);
    }

    #[Test]
    public function tryFromReturnsCorrectEnum_givenCorrectValue(): void
    {
        $enum = StringsBackedEnum::tryFrom('bar alternative');

        $this->assertEquals(StringsBackedEnum::Bar, $enum);
    }

    #[Test]
    public function fromReturnsCorrectEnum_givenCorrectValue(): void
    {
        $enum = StringsBackedEnum::from('baz alternative');

        $this->assertEquals(StringsBackedEnum::Baz, $enum);
    }

    #[Test]
    public function fromThrowsValueError_givenNonExistentValue(): void
    {
        $this->expectException(ValueError::class);

        $enum = StringsBackedEnum::from('non existent value');
    }

    #[Test]
    public function allValuesReturnsCorrectArray_givenEnum(): void
    {
        $enum = StringsBackedEnum::Bar;

        $values = $enum->allValues();

        $this->assertEqualsCanonicalizing(['bar', 'bar alternative'], $values);
    }

    #[Test]
    public function valueReturnsFirstValue_givenEnum(): void
    {
        $enum = StringsBackedEnum::Baz;

        $value = $enum->value();

        $this->assertEquals('baz', $value);
    }
}
