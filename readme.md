# Multi-backed enum

<p align="center">
  <a href="https://github.com/try-again-later/MultiBackedEnum/actions/workflows/test.yml">
    <img
      src="https://github.com/try-again-later/multibackedenum/actions/workflows/test.yml/badge.svg"
      alt="Tests"
    >
  </a>
  <a href="https://packagist.org/packages/try-again-later/multi-backed-enum">
    <img
      src="https://img.shields.io/packagist/v/try-again-later/multi-backed-enum"
      alt="Latest Version"
    >
  </a>
  <a href="https://packagist.org/packages/try-again-later/multi-backed-enum">
    <img
      src="https://img.shields.io/packagist/l/try-again-later/multi-backed-enum"
      alt="Latest Version"
    >
  </a>
</p>

Небольшая библиотека для PHP 8.1+, позволяющая создавать перечисления, вариантам которых
может соответствовать сразу несколько скалярных значений (целых чисел или строк). Скалярные значения
указываются с помощью атрибутов на вариантах перечисления, а новые методы добавляются через трейты.

Библиотека позволяет конвертировать скалярные значения в варианты перечисления и обратно.

По сути это как "backed" перечисления из PHP 8.1, но с возможностью указать несколько значений для
одного варианта. Интерфейс повторяет методы "backed" перечислений из PHP 8.1, но также включает
метод `allValues()`, позволяющий получить весь список скалярных значений назначенных для конкретного
варианта перечисления.

---

A small PHP 8.1+ library for creating enumerations with cases backed by multiple values. Useful when
you have a bunch of "backing" values (strings or integers) all of which identify the same
enumeration case. Backing values are specified using attributes applied to the enumeration cases and
the new methods are added via traits.

The library allows you to convert backing values into enumeration cases and vice versa.

The interface mimics PHP 8.1.0 backed enums with an addition of method `allValues()`, which returns
a list of all "backing" values.

## Installation

Via composer:

```sh
$ composer require try-again-later/multi-backed-enum
```

## Example

```php
use TryAgainLater\MultiBackedEnum\{MultiBackedEnum, Values, MakeMultiBacked};

#[MultiBackedEnum]
enum Status
{
  #[Values('on', 'true', 'yes')]
  case ON;

  #[Values('off', 'false', 'no', 'null')]
  case OFF;

  use MakeMultiBacked;
}

// Status::ON
$status = Status::tryFrom('true');

// Throws a ValueError
$status = Status::from('some bad value');

// Returns the first one from the list.
// 'off'
$stringStatus = Status::OFF->value();

// ['on', 'true', 'yes']
$stringStatuses = Status::ON->allValues();
```

## Running tests and linter (on the library iteself)

```sh
composer test
composer lint
```
