<?php

use App\Domain\Support\Exceptions\RepositoryValidationException;
use Illuminate\Support\Arr;

const NULLABLE_IDENTIFIER = '---nullable-value---';
const OMITTABLE_IDENTIFIER = '---omittable-value---';

/**
 * Create an omittable context function, for use with RepositoryArray::make([]).
 * An omittable value can be omitted from the input array, but if specified, must have a (non-null) value. For nullable version of this use omittableNullable()
 *
 * @param $key
 * @return Closure
 */
function omittable($key)
{
    return function ($array) use ($key) {
        if (is_iterable($key)) {
            $searchKeys = $key;

            // Search for assoc array keys
            if(is_array($key) && is_assoc_array($key)){
                $searchKeys = array_keys($key);
            }

            $firstFoundKey = collect($searchKeys)->first(fn($property) => Arr::has($array, $property));

            if (!$firstFoundKey) {
                return OMITTABLE_IDENTIFIER;
            }

            if (is_null(Arr::get($array, $firstFoundKey, OMITTABLE_IDENTIFIER))) {
                throw new RepositoryValidationException([$firstFoundKey => ["$firstFoundKey must be non-null"]]);
            }

            if(is_array($key) && is_assoc_array($key)) {
                return $key[$firstFoundKey];
            }

            return Arr::get($array, $firstFoundKey);
        }

        if (is_null(Arr::get($array, $key, OMITTABLE_IDENTIFIER))) {
            throw new RepositoryValidationException([$key => ["$key must be non-null"]]);
        }

        return Arr::has($array, $key) ? Arr::get($array, $key) : OMITTABLE_IDENTIFIER;
    };
}

/**
 * Create an nullable context function, for use with RepositoryArray::make([]).
 * A nullable value cannot be omitted and must be specified, but its value may be a null
 *
 * @param $key
 * @return Closure
 */
function nullable($key, $omittable = false)
{
    return function ($array) use ($key, $omittable) {
        if (is_array($key)) {
            $firstFoundKey = collect($key)->first(fn($property) => Arr::has($array, $property));

            if (!$firstFoundKey && !$omittable) {
                $implodedKeys = implode(', ', $key);
                throw new RepositoryValidationException([$implodedKeys => ["One of '{$implodedKeys}' must be set or null."]]);
            }

            return is_null(Arr::get($array, $firstFoundKey)) ? NULLABLE_IDENTIFIER : Arr::get($array, $firstFoundKey);
        }

        if (!Arr::has($array, $key) && !$omittable) {
            throw new RepositoryValidationException([$key => ["Value '$key' must be set or null."]]);
        } else if (!Arr::has($array, $key) && $omittable) {
            return OMITTABLE_IDENTIFIER;
        }

        return is_null(Arr::get($array, $key)) ? NULLABLE_IDENTIFIER : Arr::get($array, $key);
    };
}

/**
 * Create an omittableNullable context function, for use with RepositoryArray::make([]).
 * A omittableNullable may be skipped in the input array, but if specified, can also be null
 *
 *
 * @param $key
 * @return Closure
 */
function omittableNullable($key)
{
    return function ($array) use ($key) {
        $nullableCheck = nullable($key, true)($array);

        if ($nullableCheck === NULLABLE_IDENTIFIER) {
            return NULLABLE_IDENTIFIER;
        }

        return omittable($key)($array);
    };
}

function required($key)
{
    return function ($array) use ($key) {
        $value = omittableNullable($key)($array);

        if (is_array($key) && is_assoc_array($key)) {
            $intersect = array_intersect(array_keys($array), array_keys($key));
            $morphKeyIdentifier = array_values($intersect)[0];
            return $key[$morphKeyIdentifier];
        }

        if (in_array($value, [OMITTABLE_IDENTIFIER, NULLABLE_IDENTIFIER], true)) {

            if (is_array($key)) {
                $implodedKeys = implode(', ', $key);
                throw new RepositoryValidationException([$implodedKeys => ["One of '{$implodedKeys}' must be set."]]);
            }

            throw new RepositoryValidationException([$key => ["Value of '{$key}' must be set."]]);
        }

        return $value;
    };
}

/**
 * Determine if argument is an associative array
 * Ref: https://stackoverflow.com/questions/173400/how-to-check-if-php-array-is-associative-or-sequential
 *
 * @param array $arr
 * @return bool
 */
function is_assoc_array(array $arr)
{
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}
