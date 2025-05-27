<?php

namespace App\Utils;

use function is_array;

class ArrayUtils
{
    public static function findKey($array, callable|int|string $valueOrCallback): int|string|null
    {
        if (is_int($valueOrCallback) || is_string($valueOrCallback)) {
            return self::findKeyByValue($array, $valueOrCallback);
        }

        return self::findKeyByCallback($array, $valueOrCallback);
    }

    public static function findKeyByProperties($array, array $properties): int|string|null
    {
        return self::findKeyByCallback($array, static function ($item) use ($properties) {
            if (is_array($item)) {
                foreach ($properties as $property => $value) {
                    if (!isset($item[$property]) || $item[$property] !== $value) {
                        return false;
                    }
                }
            } else {
                foreach ($properties as $property => $value) {
                    if (!isset($item->{$property}) || $item->{$property} !== $value) {
                        return false;
                    }
                }
            }

            return true;
        });
    }

    public static function findKeyByValue($array, int|string $value): int|string|null
    {
        foreach ($array as $key => $kvalue) {
            if ($kvalue === $value) {
                return $key;
            }
        }

        return null;
    }

    public static function findKeyByCallback($array, callable $callback): int|string|null
    {
        foreach ($array as $key => $value) {
            if ($callback($value)) {
                return $key;
            }
        }

        return null;
    }
}
