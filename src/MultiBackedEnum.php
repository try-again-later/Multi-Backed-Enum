<?php

declare (strict_types = 1);

namespace TryAgainLater\MultiBackedEnum;

use Attribute;

#[Attribute]
class MultiBackedEnum
{}

trait MakeMultiBacked
{
    use StaticMethods;
    use InstanceMethods;
}
