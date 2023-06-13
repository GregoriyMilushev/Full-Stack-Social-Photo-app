<?php

namespace App\Domain\Support\Helpers;

class RepositoryArray
{
    public static function make(array $originalArray, $magicArray)
    {
        $contextedValues = array_map(fn ($valContexter) => $valContexter($originalArray), $magicArray);
        $withoutOmittable = array_filter($contextedValues, fn ($value) => $value !== OMITTABLE_IDENTIFIER);
        $withNullable = array_map(fn ($value) => ($value === NULLABLE_IDENTIFIER ? null : $value), $withoutOmittable);

        return $withNullable;
    }
}
