<?php

namespace App\Rules;

use App\Models\VulnerabilityFactorType;
use Illuminate\Contracts\Validation\Rule;

class VulnerabilitiesTypeExistsAsKeyRule implements Rule
{
    public function passes($attribute, $value)
    {
        $keys = array_unique(array_keys($value));

        $count = VulnerabilityFactorType::query()->whereIn('id', $keys)->count();

        return count($keys) === $count;
    }

    public function message()
    {
        return 'Ooops. Something went wrong. Try refreshing the page.';
    }
}
