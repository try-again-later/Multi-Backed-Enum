<?php

declare(strict_types = 1);

use TryAgainLater\MultiBackedEnum\{MultiBackedEnum, Values, MakeMultiBacked};

use PHPUnit\Framework\TestCase;

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
    public function test_TryFromReturnsNull_GivenNonExistentValue()
    {
        $enum = StringsBackedEnum::tryFrom('non existent value');

        $this->assertNull($enum);
    }

    public function test_TryFromReturnsCorrectEnum_GivenCorrectValue()
    {
        $enum = StringsBackedEnum::tryFrom('bar alternative');

        $this->assertEquals(StringsBackedEnum::Bar, $enum);
    }

    public function test_FromReturnsCorrectEnum_GivenCorrectValue()
    {
        $enum = StringsBackedEnum::from('baz alternative');

        $this->assertEquals(StringsBackedEnum::Baz, $enum);
    }

    public function test_FromThrowsValueError_GivenNonExistentValue()
    {
        $this->expectException(ValueError::class);

        $enum = StringsBackedEnum::from('non existent value');
    }

    public function test_AllValuesReturnsCorrectArray_GivenEnum()
    {
        $enum = StringsBackedEnum::Bar;

        $values = $enum->allValues();

        $this->assertEqualsCanonicalizing(['bar', 'bar alternative'], $values);
    }

    public function test_ValueReturnsFirstValue_GivenEnum()
    {
        $enum = StringsBackedEnum::Baz;

        $value = $enum->value();

        $this->assertEquals('baz', $value);
    }
}
