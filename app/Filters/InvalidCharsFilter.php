<?php

declare(strict_types=1);

namespace App\Filters;

/**
 * InvalidCharsFilter
 *
 * Extends the framework InvalidChars filter to tolerate scalar JSON values
 * like booleans and numbers without raising type errors.
 */
class InvalidCharsFilter extends \CodeIgniter\Filters\InvalidChars
{
    /**
     * @param array|string|int|float|bool|null $value
     * @return array|string|int|float|bool|null
     */
    protected function checkEncoding($value)
    {
        if (is_array($value)) {
            array_map($this->checkEncoding(...), $value);
            return $value;
        }

        if (! is_string($value)) {
            return $value;
        }

        return parent::checkEncoding($value);
    }

    /**
     * @param array|string|int|float|bool|null $value
     * @return array|string|int|float|bool|null
     */
    protected function checkControl($value)
    {
        if (is_array($value)) {
            array_map($this->checkControl(...), $value);
            return $value;
        }

        if (! is_string($value)) {
            return $value;
        }

        return parent::checkControl($value);
    }
}
