<?php

namespace App\Rules;

use App\Models\Entity;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class Nested implements ValidationRule
{
    public function __construct(
        protected ?Entity $self = null
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Don't allow setting the parent to an entity that is included in the target's children
        if (empty($value) || empty($this->self)) {
            return;
        }

        /** @var ?Entity $parent */
        $parent = Entity::where('id', $value)->first();
        if (! $parent) {
            return;
        }

        $bloodline = $parent->ancestorsAndSelf()->pluck('id')->toArray();
        if (in_array($this->self->id, $bloodline)) {
            $fail('validation.nested_loop')->translate(['parent' => $parent->name]);
        }
    }
}
