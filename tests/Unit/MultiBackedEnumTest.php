<?php

declare(strict_types = 1);

use TryAgainLater\MultiBackedEnum\{MultiBackedEnum, Values, MakeMultiBacked};

use PHPUnit\Framework\TestCase;

#[MultiBackedEnum]
enum DummyCorrectEnum
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
        $enum = DummyCorrectEnum::tryFrom('non existent value');

        $this->assertNull($enum);
    }

    public function test_TryFromReturnsCorrectEnum_GivenCorrectValue()
    {
        $enum = DummyCorrectEnum::tryFrom('bar alternative');

        $this->assertEquals(DummyCorrectEnum::Bar, $enum);
    }

    public function test_FromReturnsCorrectEnum_GivenCorrectValue()
    {
        $enum = DummyCorrectEnum::from('baz alternative');

        $this->assertEquals(DummyCorrectEnum::Baz, $enum);
    }

    public function test_FromThrowsValueError_GivenNonExistentValue()
    {
        $this->expectException(ValueError::class);

        $enum = DummyCorrectEnum::from('non existent value');
    }

    public function test_AllValuesReturnsCorrectArray_GivenEnum()
    {
        $enum = DummyCorrectEnum::Bar;

        $values = $enum->allValues();

        $this->assertEqualsCanonicalizing(['bar', 'bar alternative'], $values);
    }

    public function test_ValueReturnsFirstValue_GivenEnum()
    {
        $enum = DummyCorrectEnum::Baz;

        $value = $enum->value();

        $this->assertEquals('baz', $value);
    }
}
