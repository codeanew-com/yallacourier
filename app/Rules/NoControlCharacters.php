<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Rejects line breaks and other control characters.
 *
 * Used with every `email` rule: Laravel 11's email rule can let a CR/LF through
 * (advisory PKSA-3r5d-mb8f-1qw9 / CVE-2026-48019, fixed only in Laravel 12.60+),
 * and these addresses are later used as mail recipients, where a line break
 * could inject email headers.
 */
class NoControlCharacters implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_string($value) && preg_match('/[\x00-\x1F\x7F]/', $value)) {
            $fail('The :attribute must not contain line breaks or control characters.');
        }
    }
}
